<?php

declare(strict_types=1);

$project = dirname(__DIR__, 2);
$sourceRoot = $project.'/src';
$backupRoot = $project.'/var/canonicalization-backup-20260912';
$retiredRoot = $project.'/var/retired-canonical-layout';
$marker = $backupRoot.'/.completed';

if (is_file($marker)) {
    fwrite(STDOUT, "Canonical type migration already completed.\n");
    exit(0);
}

$explicitNames = [
    'CompliancePolicyDecisionDTO' => 'CompliancePolicyDecisionDTO',
    'CompliancePolicyFactSetDTO' => 'CompliancePolicyFactSetDTO',
    'ComplianceRiskScoreDTO' => 'ComplianceRiskScoreDTO',
    'ComplianceLimitPolicyEntity' => 'ComplianceLimitPolicyEntity',
    'ComplianceRetentionPolicyEntity' => 'ComplianceRetentionPolicyEntity',
    'CompliancePolicyEvaluationService' => 'CompliancePolicyEvaluationService',
    'ComplianceExpressionAwarePolicyEvaluationService' => 'ComplianceExpressionAwarePolicyEvaluationService',
    'ComplianceMessengerPolicyEvaluationService' => 'ComplianceMessengerPolicyEvaluationService',
    'ComplianceRiskAwarePolicyEvaluationService' => 'ComplianceRiskAwarePolicyEvaluationService',
    'ComplianceRoleAwarePolicyEvaluationService' => 'ComplianceRoleAwarePolicyEvaluationService',
    'ComplianceTenantAwarePolicyEvaluationService' => 'ComplianceTenantAwarePolicyEvaluationService',
    'ComplianceTracingPolicyEvaluationService' => 'ComplianceTracingPolicyEvaluationService',
    'CompliancePolicyEvaluationServiceInterface' => 'CompliancePolicyEvaluationServiceInterface',
    'ComplianceFactMappingService' => 'ComplianceFactMappingService',
];

$types = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceRoot, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if (!$file instanceof SplFileInfo || !$file->isFile() || 'php' !== strtolower($file->getExtension())) {
        continue;
    }

    $contents = (string) file_get_contents($file->getPathname());
    if (1 !== preg_match('/^namespace\s+([^;]+);/m', $contents, $namespaceMatch)) {
        continue;
    }
    if (1 !== preg_match('/\b(?:final\s+|abstract\s+|readonly\s+)*(?:class|interface|trait|enum)\s+([A-Za-z_][A-Za-z0-9_]*)/', $contents, $typeMatch)) {
        continue;
    }

    $oldName = $typeMatch[1];
    if (in_array($oldName, ['Kernel', 'ComplyingBundle'], true)) {
        continue;
    }

    $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($project) + 1));
    $oldNamespace = $namespaceMatch[1];
    $newName = $explicitNames[$oldName] ?? $oldName;
    if (!str_starts_with($newName, 'Compliance')) {
        $newName = str_contains($newName, 'Compliance')
            ? 'Compliance'.str_replace('Compliance', '', $newName)
            : 'Compliance'.$newName;
    }

    $targetRelative = $relative;
    $targetNamespace = $oldNamespace;

    if (str_starts_with($relative, 'src/EventListener/')) {
        $targetRelative = 'src/Listener/'.substr($relative, strlen('src/EventListener/'));
        $targetNamespace = str_replace('\\EventListener', '\\Listener', $oldNamespace);
    } elseif (str_starts_with($relative, 'src/MessageHandler/')) {
        $targetRelative = 'src/Handler/'.substr($relative, strlen('src/MessageHandler/'));
        $targetNamespace = str_replace('\\MessageHandler', '\\Handler', $oldNamespace);
    } elseif (str_starts_with($relative, 'src/Mapper/')) {
        $targetRelative = 'src/Service/Mapping/'.substr($relative, strlen('src/Mapper/'));
        $targetNamespace = str_replace('\\Mapper', '\\Service\\Mapping', $oldNamespace);
    } elseif (str_starts_with($relative, 'src/Adapter/')) {
        $targetRelative = 'src/Service/Integration/'.substr($relative, strlen('src/Adapter/'));
        $targetNamespace = str_replace('\\Adapter', '\\Service\\Integration', $oldNamespace);
        if (str_ends_with($newName, 'Adapter')) {
            $newName = substr($newName, 0, -7).'IntegrationService';
        } elseif (!str_ends_with($newName, 'Service')) {
            $newName .= 'Service';
        }
    } elseif (str_starts_with($relative, 'src/Service/')) {
        $role = null;
        foreach (['Provider', 'Resolver', 'Repository'] as $candidate) {
            if (str_ends_with($newName, $candidate)) {
                $role = $candidate;
                break;
            }
        }
        if (null !== $role) {
            $tail = substr($relative, strlen('src/Service/'));
            $targetRelative = 'src/'.$role.'/'.$tail;
            $targetNamespace = preg_replace('/^App\\\\Complying\\\\Service/', 'App\\\\Complying\\\\'.$role, $oldNamespace) ?? $oldNamespace;
        }
    }

    $targetRelative = preg_replace('#/[^/]+\.php$#', '/'.$newName.'.php', $targetRelative) ?? $targetRelative;
    $types[] = [
        'oldName' => $oldName,
        'newName' => $newName,
        'oldFqcn' => $oldNamespace.'\\'.$oldName,
        'newFqcn' => $targetNamespace.'\\'.$newName,
        'source' => $relative,
        'target' => $targetRelative,
        'targetNamespace' => $targetNamespace,
    ];
}

$targets = [];
foreach ($types as $type) {
    if (isset($targets[$type['target']]) && $targets[$type['target']] !== $type['source']) {
        throw new RuntimeException('Canonical rename collision at '.$type['target']);
    }
    $targets[$type['target']] = $type['source'];
}

$extensions = ['php', 'yaml', 'yml', 'twig', 'md', 'json', 'xml', 'sql', 'sh', 'ps1'];
$textFiles = [];
$tree = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($project, FilesystemIterator::SKIP_DOTS));
foreach ($tree as $file) {
    if (!$file instanceof SplFileInfo || !$file->isFile()) {
        continue;
    }
    $path = str_replace('\\', '/', $file->getPathname());
    if (str_contains($path, '/vendor/') || str_contains($path, '/var/') || str_contains($path, '/.git/') || str_contains($path, '/.gating/.gating/')) {
        continue;
    }
    if (in_array(strtolower($file->getExtension()), $extensions, true)) {
        $textFiles[] = $file->getPathname();
    }
}

foreach ($textFiles as $path) {
    $relative = str_replace('\\', '/', substr($path, strlen($project) + 1));
    $backup = $backupRoot.'/'.$relative;
    if (!is_dir(dirname($backup)) && !mkdir(dirname($backup), 0777, true) && !is_dir(dirname($backup))) {
        throw new RuntimeException('Unable to create backup directory for '.$relative);
    }
    if (!is_file($backup) && !copy($path, $backup)) {
        throw new RuntimeException('Unable to back up '.$relative);
    }

    $contents = (string) file_get_contents($path);
    foreach ($types as $type) {
        $contents = str_replace($type['oldFqcn'], $type['newFqcn'], $contents);
        $contents = preg_replace('/\b'.preg_quote($type['oldName'], '/').'\b/', $type['newName'], $contents) ?? $contents;
    }
    if (false === file_put_contents($path, $contents)) {
        throw new RuntimeException('Unable to update '.$relative);
    }
}

foreach ($types as $type) {
    $source = $project.'/'.$type['source'];
    if (!is_file($source)) {
        continue;
    }

    $contents = (string) file_get_contents($source);
    $contents = preg_replace('/^namespace\s+[^;]+;/m', 'namespace '.$type['targetNamespace'].';', $contents, 1) ?? $contents;
    if (false === file_put_contents($source, $contents)) {
        throw new RuntimeException('Unable to update namespace in '.$type['source']);
    }

    $target = $project.'/'.$type['target'];
    if ($source === $target) {
        continue;
    }
    if (file_exists($target)) {
        throw new RuntimeException('Rename target already exists: '.$type['target']);
    }
    if (!is_dir(dirname($target)) && !mkdir(dirname($target), 0777, true) && !is_dir(dirname($target))) {
        throw new RuntimeException('Unable to create target directory for '.$type['target']);
    }
    if (!rename($source, $target)) {
        throw new RuntimeException('Unable to move '.$type['source'].' to '.$type['target']);
    }
}

foreach (['Adapter', 'EventListener', 'Mapper', 'MessageHandler'] as $legacyRoot) {
    $legacy = $sourceRoot.'/'.$legacyRoot;
    if (!is_dir($legacy)) {
        continue;
    }
    $remaining = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($legacy, FilesystemIterator::SKIP_DOTS));
    foreach ($remaining as $remainingEntry) {
        if ($remainingEntry instanceof SplFileInfo && $remainingEntry->isFile()) {
            throw new RuntimeException('Legacy role root still contains files: src/'.$legacyRoot);
        }
    }
    $retired = $retiredRoot.'/'.$legacyRoot;
    if (!is_dir(dirname($retired)) && !mkdir(dirname($retired), 0777, true) && !is_dir(dirname($retired))) {
        throw new RuntimeException('Unable to create retired layout directory.');
    }
    if (!rename($legacy, $retired)) {
        throw new RuntimeException('Unable to retire legacy role root src/'.$legacyRoot);
    }
}

if (!is_dir($backupRoot) && !mkdir($backupRoot, 0777, true) && !is_dir($backupRoot)) {
    throw new RuntimeException('Unable to create migration marker directory.');
}
file_put_contents($backupRoot.'/manifest.json', json_encode($types, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
file_put_contents($marker, gmdate(DATE_ATOM).PHP_EOL);
fwrite(STDOUT, sprintf("Canonicalized %d PHP type identities.\n", count($types)));
