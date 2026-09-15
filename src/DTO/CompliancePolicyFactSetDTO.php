<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\DTO;

/**
 * Carries immutable compliance policy fact set d t o data across an explicit compliance application boundary.
 */
final class CompliancePolicyFactSetDTO
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $facts
     */
    public function __construct(
        public readonly string $subject,
        public readonly string $action,
        public readonly ?string $resource,
        public readonly array $facts,
    ) {
    }

    /**
     * Performs the from event behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $facts
     */
    public static function fromEvent(string $eventName, array $facts): self
    {
        return new self(
            subject: $facts['tenant_id'] ?? 'system',
            action: $eventName,
            resource: $facts['object_id'] ?? null,
            facts: $facts,
        );
    }

    /**
     * Performs the to array behavior as part of the owning compliance responsibility.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'subject' => $this->subject,
            'action' => $this->action,
            'resource' => $this->resource,
            'facts' => $this->facts,
        ];
    }
}
