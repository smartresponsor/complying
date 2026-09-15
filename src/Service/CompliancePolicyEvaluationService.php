<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\DTO\CompliancePolicyFactSetDTO;
use App\Complying\Service\Mapping\ComplianceFactMappingService;
use App\Complying\Service\Policy\ComplianceRolePolicyClient;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;

/**
 * Coordinates the compliance policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceRolePolicyClient $client,
        private readonly ComplianceFactMappingService $factMapper,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $facts = $this->factMapper->map($eventName, $payload);

        $factSet = CompliancePolicyFactSetDTO::fromEvent($eventName, $facts);
        $decision = $this->client->decide($factSet);

        $outcome = $decision->outcome;
        if ('PERMIT_WITH_OBLIGATION' === $outcome) {
            $outcome = 'REVIEW';
        }

        return new ComplianceDecisionDTO(
            $outcome,
            $decision->policyId,
            $decision->policyVersion,
            $facts
        );
    }
}
