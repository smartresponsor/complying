<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class ExpressionAwareCompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $inner,
        private readonly PolicyExpressionProvider $provider,
        private readonly PolicyExpressionEvaluator $evaluator,
    ) {
    }

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
