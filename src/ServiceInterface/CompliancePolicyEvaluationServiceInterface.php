<?php

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

use App\Complying\DTO\ComplianceDecisionDTO;

/**
 * Defines the behavioral contract for compliance policy evaluation service interface collaborators in the compliance component.
 */
interface CompliancePolicyEvaluationServiceInterface
{
    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO;
}
