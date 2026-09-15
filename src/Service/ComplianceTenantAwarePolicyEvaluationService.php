<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Coordinates the compliance tenant aware policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceTenantAwarePolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $inner,
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $req = $this->requestStack->getCurrentRequest();
        if ($req && $req->attributes->has('compliance_tenant_id')) {
            $payload['tenant_id'] = $req->attributes->get('compliance_tenant_id');
        }

        $decision = $this->inner->decide($eventName, $payload);

        $decision->facts['tenant_id'] = $payload['tenant_id'] ?? $decision->facts['tenant_id'] ?? null;

        return $decision;
    }
}
