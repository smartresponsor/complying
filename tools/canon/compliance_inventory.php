<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2).'/src';
$issues = [];
$allowedRoots = [
    'Builder', 'BuilderInterface', 'Command', 'Controller', 'DependencyInjection', 'DTO',
    'Entity', 'Enum', 'Event', 'Form', 'FormInterface', 'Handler', 'Kernel.php', 'Listener',
    'Message', 'Policy', 'Provider', 'Repository', 'RepositoryInterface', 'Resolver',
    'Responder', 'Service', 'ServiceInterface', 'Snapshot', 'Subscriber', 'ValueObject',
];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if (!$file instanceof SplFileInfo || !$file->isFile() || 'php' !== strtolower($file->getExtension())) {
        continue;
    }

    $relative = str_replace('\\', '/', substr($file->getPathname(), strlen(dirname(__DIR__, 2)) + 1));
    $contents = (string) file_get_contents($file->getPathname());
    if (1 !== preg_match('/\b(?:final\s+|abstract\s+|readonly\s+)*(?:class|interface|trait|enum)\s+([A-Za-z_][A-Za-z0-9_]*)/', $contents, $match)) {
        continue;
    }

    $name = $match[1];
    $rootPart = explode('/', substr($relative, 4))[0];
    if (!str_starts_with($name, 'Compliance') && !in_array($name, ['Kernel', 'ComplyingBundle'], true)) {
        $issues[] = ['kind' => 'prefix', 'path' => $relative, 'type' => $name];
    }
    if (!in_array($rootPart, $allowedRoots, true) && !str_ends_with($relative, 'ComplyingBundle.php')) {
        $issues[] = ['kind' => 'root', 'path' => $relative, 'type' => $name];
    }
}

fwrite(STDOUT, json_encode($issues, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL);
