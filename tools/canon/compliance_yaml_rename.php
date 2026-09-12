<?php

declare(strict_types=1);

/**
 * Moves legacy configuration filenames to their Canon038-compliant identities.
 */
$root = dirname(__DIR__, 2);
$renames = [
    'config/packages/compliance.yaml' => 'config/packages/compliance_core.yaml',
    'config/packages/messenger_compliance.yaml' => 'config/packages/messenger.yaml',
    'config/services_autowire.yaml' => 'config/compliance_services_autowire.yaml',
];

foreach ($renames as $source => $target) {
    $sourcePath = $root.'/'.$source;
    $targetPath = $root.'/'.$target;

    if (!is_file($sourcePath)) {
        if (is_file($targetPath)) {
            continue;
        }

        throw new RuntimeException(sprintf('Source file is missing: %s', $source));
    }

    if (file_exists($targetPath)) {
        throw new RuntimeException(sprintf('Target already exists: %s', $target));
    }

    if (!rename($sourcePath, $targetPath)) {
        throw new RuntimeException(sprintf('Unable to move %s to %s', $source, $target));
    }
}
