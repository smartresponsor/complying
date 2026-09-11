<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class TracingCompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $inner,
        private readonly ComplianceOtelTracer $tracer,
    ) {
    }

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
