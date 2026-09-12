<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\DTO;

/**
 * Carries immutable compliance policy decision d t o data across an explicit compliance application boundary.
 */
final class CompliancePolicyDecisionDTO
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
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
     * Performs the from array behavior as part of the owning compliance responsibility.
     *
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
