<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Exception;

final class ComplianceDeniedException extends \RuntimeException
{
    public function __construct(string $message = 'Operation blocked by compliance')
    {
        parent::__construct($message);
    }
}
