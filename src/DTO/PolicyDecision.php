<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\DTO;

final class PolicyDecision
{
    /**
     * @param array<string, mixed> $obligations
     */
    public function __construct(
        public readonly string $outcome,
        public readonly ?string $policyId,
        public readonly ?string $policyVersion,
        public readonly array $obligations = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['outcome'] ?? 'PERMIT',
            $data['policy_id'] ?? null,
            $data['policy_version'] ?? null,
            $data['obligations'] ?? []
        );
    }
}
