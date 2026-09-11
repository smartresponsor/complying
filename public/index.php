<?php

declare(strict_types=1);

use App\Complying\Kernel;

if (!is_file(dirname(__DIR__).'/vendor/autoload_runtime.php')) {
    throw new RuntimeException('Run "composer install" before serving the application.');
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return static function (array $context): Kernel {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
