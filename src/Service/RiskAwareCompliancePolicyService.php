<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class RiskAwareCompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $inner,
        private readonly RiskScoreService $risk,
    ) {
    }

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
