<?php

declare(strict_types=1);

$project = dirname(__DIR__, 2);
$source = $project.'/src/Listener/ComplianceOrderPlacedSubscriber.php';
$target = $project.'/src/EventSubscriber/ComplianceOrderPlacedSubscriber.php';
$backup = $project.'/var/canonicalization-backup-20260912/src/Listener/ComplianceOrderPlacedSubscriber.php';

if (!is_file($source)) {
    if (is_file($target)) {
        fwrite(STDOUT, "Listener role finalization already completed.\n");
        exit(0);
    }

    throw new RuntimeException('Order placed listener source is missing.');
}

if (!is_dir(dirname($backup)) && !mkdir(dirname($backup), 0777, true) && !is_dir(dirname($backup))) {
    throw new RuntimeException('Unable to create listener backup directory.');
}
if (!is_file($backup) && !copy($source, $backup)) {
    throw new RuntimeException('Unable to back up order placed listener.');
}

$extensions = ['php', 'yaml', 'yml', 'twig', 'md', 'json', 'xml'];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($project, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if (!$file instanceof SplFileInfo || !$file->isFile() || !in_array(strtolower($file->getExtension()), $extensions, true)) {
        continue;
    }
    $path = str_replace('\\', '/', $file->getPathname());
    if (str_contains($path, '/vendor/') || str_contains($path, '/var/') || str_contains($path, '/.gating/.gating/')) {
        continue;
    }
    $contents = (string) file_get_contents($file->getPathname());
    $contents = str_replace(
        ['App\\Complying\\Listener\\ComplianceOrderPlacedSubscriber', 'ComplianceOrderPlacedSubscriber'],
        ['App\\Complying\\EventSubscriber\\ComplianceOrderPlacedSubscriber', 'ComplianceOrderPlacedSubscriber'],
        $contents,
    );
    file_put_contents($file->getPathname(), $contents);
}

$contents = (string) file_get_contents($source);
$contents = str_replace('namespace App\\Complying\\Listener;', 'namespace App\\Complying\\EventSubscriber;', $contents);
file_put_contents($source, $contents);

if (file_exists($target)) {
    throw new RuntimeException('Order placed subscriber target already exists.');
}
if (!rename($source, $target)) {
    throw new RuntimeException('Unable to move the order placed subscriber.');
}

$legacy = $project.'/src/Listener';
$retired = $project.'/var/retired-canonical-layout/Listener';
if (is_dir($legacy)) {
    if (!is_dir(dirname($retired)) && !mkdir(dirname($retired), 0777, true) && !is_dir(dirname($retired))) {
        throw new RuntimeException('Unable to create retired listener directory.');
    }
    if (!rename($legacy, $retired)) {
        throw new RuntimeException('Unable to retire the legacy Listener root.');
    }
}

fwrite(STDOUT, "Order placed listener migrated to EventSubscriber.\n");
