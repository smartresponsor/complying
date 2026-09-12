<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;

/**
 * Coordinates the compliance tracing policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceTracingPolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $inner,
        private readonly ComplianceOtelTracer $tracer,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $span = $this->tracer->start('compliance.decide', [
            'event' => $eventName,
            'object_id' => $payload['id'] ?? null,
        ]);

        try {
            $decision = $this->inner->decide($eventName, $payload);
            $span->setAttribute('outcome', $decision->outcome);
            $span->setAttribute('tenant_id', $decision->facts['tenant_id'] ?? '');
            $span->setAttribute('policy_id', $decision->facts['policy_id'] ?? '');
        } finally {
            $this->tracer->end($span);
        }

        return $decision;
    }
}
