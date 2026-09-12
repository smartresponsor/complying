<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Exception;

/**
 * Coordinates the compliance denied exception responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDeniedException extends \RuntimeException
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(string $message = 'Operation blocked by compliance')
    {
        parent::__construct($message);
    }
}
