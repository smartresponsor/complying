<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Message;

final class ComplianceDecisionMessage
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        private readonly string $eventName,
        private readonly array $payload,
    ) {
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @return array<string, mixed>
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
