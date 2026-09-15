<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Provider\CompliancePolicyExpressionProvider;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;

/**
 * Coordinates the compliance expression aware policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceExpressionAwarePolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $inner,
        private readonly CompliancePolicyExpressionProvider $provider,
        private readonly CompliancePolicyExpressionEvaluator $evaluator,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $decision = $this->inner->decide($eventName, $payload);

        $expr = $this->provider->get($eventName);
        if ($expr) {
            $facts = $decision->facts + $payload;
            if ($this->evaluator->evaluate($expr, $facts)) {
                // if expression is true → tighten decision
                if ('PERMIT' === $decision->outcome) {
                    $decision->outcome = 'REVIEW';
                }
                $decision->facts['expression_matched'] = $expr;
            }
        }

        return $decision;
    }
}
