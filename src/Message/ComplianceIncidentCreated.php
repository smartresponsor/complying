<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Message;

/**
 * Coordinates the compliance incident created responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceIncidentCreated
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        public readonly string $eventName,
        public readonly string $outcome,
        public readonly ?string $objectId,
        /** @var array<string, mixed> */
        public readonly array $facts = [],
    ) {
    }
}
