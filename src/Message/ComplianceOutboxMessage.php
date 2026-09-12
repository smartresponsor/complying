<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Message;

/**
 * Coordinates the compliance outbox message responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOutboxMessage
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $payload */
    public function __construct(public readonly string $type, public readonly array $payload)
    {
    }
}
