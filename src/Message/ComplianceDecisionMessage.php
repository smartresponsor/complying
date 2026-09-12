<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Message;

/**
 * Coordinates the compliance decision message responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDecisionMessage
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function __construct(
        private readonly string $eventName,
        private readonly array $payload,
    ) {
    }

    /**
     * Returns the get event name value exposed by this compliance responsibility.
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * Returns the get payload value exposed by this compliance responsibility.
     *
     * @return array<string, mixed>
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
