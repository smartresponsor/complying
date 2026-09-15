<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;

/**
 * Coordinates the compliance risk aware policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRiskAwarePolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $inner,
        private readonly ComplianceRiskScoreService $risk,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $decision = $this->inner->decide($eventName, $payload);
        $riskDto = $this->risk->calculate($decision->facts);

        if ($riskDto->score >= 90) {
            $decision->outcome = 'DENY';
        } elseif ($riskDto->score >= 60 && 'PERMIT' === $decision->outcome) {
            $decision->outcome = 'REVIEW';
        }

        $decision->facts['risk'] = $riskDto->toArray();

        return $decision;
    }
}
