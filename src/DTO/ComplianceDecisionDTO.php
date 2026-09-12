<?php

declare(strict_types=1);

namespace App\Complying\DTO;

final class ComplianceDecisionDTO
{
    /**
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
