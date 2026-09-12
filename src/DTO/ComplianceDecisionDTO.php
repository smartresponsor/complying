<?php

declare(strict_types=1);

namespace App\Complying\DTO;

/**
 * Carries immutable compliance decision d t o data across an explicit compliance application boundary.
 */
final class ComplianceDecisionDTO
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $facts
     */
    public function __construct(
        public string $outcome,
        public readonly ?string $policyId,
        public readonly ?string $policyVersion,
        public array $facts,
    ) {
    }
}
