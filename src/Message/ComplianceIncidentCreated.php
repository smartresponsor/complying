<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Message;

final class ComplianceIncidentCreated
{
    public function __construct(
        public readonly string $eventName,
        public readonly string $outcome,
        public readonly ?string $objectId,
        /** @var array<string, mixed> */
        public readonly array $facts = [],
    ) {
    }
}
