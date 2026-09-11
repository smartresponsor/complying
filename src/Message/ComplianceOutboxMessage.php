<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Message;

final class ComplianceOutboxMessage
{
    public function __construct(public readonly string $type, public readonly array $payload)
    {
    }
}
