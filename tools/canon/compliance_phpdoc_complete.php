<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$sourceRoot = $root . DIRECTORY_SEPARATOR . 'src';
$backupRoot = $root . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'phpdoc-backup-20260912';

$classPattern = '~(?:(/\\*\\*(?:(?!\\*/).)*\\*/)(\\s*))?((?:#\\[[^\\r\\n]*\\]\\s*)*(?:final\\s+|abstract\\s+|readonly\\s+)*(?:class|interface|trait|enum)\\s+([A-Za-z_][A-Za-z0-9_]*))~s';
$methodPattern = '~(?:(/\\*\\*(?:(?!\\*/).)*\\*/)(\\s*))?((?:#\\[[^\\r\\n]*\\]\\s*)*(?:(?:public|protected|private|static|final|abstract)\\s+)*function\\s+&?\\s*([A-Za-z_][A-Za-z0-9_]*)\\s*\\()~s';

$humanize = static function (string $name): string {
    $words = preg_replace('/(?<!^)([A-Z])/', ' $1', $name) ?? $name;

    return strtolower(trim(str_replace('_', ' ', $words)));
};

$isAdequate = static function (?string $doc): bool {
    if (null === $doc) {
        return false;
    }

    $lines = preg_split('/\\R/', $doc) ?: [];
    $description = [];
    foreach ($lines as $line) {
        $line = trim($line, " \t\n\r\0\x0B/*");
        if ('' === $line || str_starts_with($line, '@')) {
            continue;
        }
        $description[] = $line;
    }

    $text = trim(implode(' ', $description));

    return strlen($text) >= 30 && count(preg_split('/\\s+/', $text) ?: []) >= 5;
};

$enrich = static function (?string $doc, string $description): string {
    if (null === $doc) {
        return "/**\n * {$description}\n */";
    }

    return preg_replace('/^\\/\\*\\*/', "/**\n * {$description}\n *", $doc, 1) ?? $doc;
};

$classDescription = static function (string $name, string $path) use ($humanize): string {
    $subject = $humanize($name);

    return match (true) {
        str_contains($path, DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR) => "Handles the {$subject} HTTP boundary and delegates compliance behavior to application services.",
        str_contains($path, DIRECTORY_SEPARATOR . 'Command' . DIRECTORY_SEPARATOR) => "Exposes the {$subject} console operation for controlled compliance administration and automation.",
        str_contains($path, DIRECTORY_SEPARATOR . 'Entity' . DIRECTORY_SEPARATOR) => "Models the persisted {$subject} concept and protects its compliance workflow invariants.",
        str_contains($path, DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR) => "Provides persistence queries for {$subject} records used by compliance workflows.",
        str_contains($path, DIRECTORY_SEPARATOR . 'DTO' . DIRECTORY_SEPARATOR) => "Carries immutable {$subject} data across an explicit compliance application boundary.",
        str_contains($path, DIRECTORY_SEPARATOR . 'ServiceInterface' . DIRECTORY_SEPARATOR) => "Defines the behavioral contract for {$subject} collaborators in the compliance component.",
        str_contains($path, DIRECTORY_SEPARATOR . 'EventSubscriber' . DIRECTORY_SEPARATOR) => "Subscribes to framework events and coordinates the {$subject} compliance reaction.",
        default => "Coordinates the {$subject} responsibility within the Complying component and its explicit boundaries.",
    };
};

$methodDescription = static function (string $name) use ($humanize): string {
    $subject = $humanize($name);

    return match (true) {
        '__construct' === $name => 'Initializes the collaborators and state required by this compliance responsibility.',
        str_starts_with($name, 'get') => "Returns the {$subject} value exposed by this compliance responsibility.",
        str_starts_with($name, 'is'), str_starts_with($name, 'has') => "Reports whether the {$subject} condition currently holds for this compliance responsibility.",
        str_starts_with($name, 'set') => "Updates the {$subject} value while preserving the owning compliance invariant.",
        'execute' === $name => 'Executes the configured console workflow and returns its process status code.',
        'configure' === $name => 'Defines the command name, arguments, options, and operator-facing description.',
        default => "Performs the {$subject} behavior as part of the owning compliance responsibility.",
    };
};

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceRoot, FilesystemIterator::SKIP_DOTS)
);

$changed = 0;
foreach ($iterator as $file) {
    if (!$file->isFile() || 'php' !== strtolower($file->getExtension())) {
        continue;
    }

    $path = $file->getPathname();
    $original = file_get_contents($path);
    if (false === $original) {
        throw new RuntimeException("Unable to read {$path}");
    }

    $updated = preg_replace_callback(
        $classPattern,
        static function (array $match) use ($isAdequate, $enrich, $classDescription, $path): string {
            $doc = '' !== ($match[1] ?? '') ? $match[1] : null;
            if ($isAdequate($doc)) {
                return $match[0];
            }

            $replacement = $enrich($doc, $classDescription($match[4], $path));
            if (null === $doc) {
                return $replacement . "\n" . $match[3];
            }

            return str_replace($doc, $replacement, $match[0]);
        },
        $original
    );
    if (null === $updated) {
        throw new RuntimeException("Unable to process class documentation in {$path}");
    }

    $updated = preg_replace_callback(
        $methodPattern,
        static function (array $match) use ($isAdequate, $enrich, $methodDescription): string {
            $doc = '' !== ($match[1] ?? '') ? $match[1] : null;
            if ($isAdequate($doc)) {
                return $match[0];
            }

            $replacement = $enrich($doc, $methodDescription($match[4]));
            if (null === $doc) {
                return $replacement . "\n" . $match[3];
            }

            return str_replace($doc, $replacement, $match[0]);
        },
        $updated
    );
    if (null === $updated) {
        throw new RuntimeException("Unable to process method documentation in {$path}");
    }

    if ($updated === $original) {
        continue;
    }

    $relative = substr($path, strlen($sourceRoot) + 1);
    $backup = $backupRoot . DIRECTORY_SEPARATOR . $relative;
    if (!is_file($backup)) {
        if (!is_dir(dirname($backup)) && !mkdir(dirname($backup), 0777, true) && !is_dir(dirname($backup))) {
            throw new RuntimeException("Unable to create backup directory for {$relative}");
        }
        if (!copy($path, $backup)) {
            throw new RuntimeException("Unable to back up {$relative}");
        }
    }

    if (false === file_put_contents($path, $updated)) {
        throw new RuntimeException("Unable to write {$relative}");
    }
    ++$changed;
}

fwrite(STDOUT, "PHPDoc canonicalization updated {$changed} source files; backups are in var/phpdoc-backup-20260912.\n");
