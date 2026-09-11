<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\DTO;

final class PolicyFactSet
{
    /**
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
