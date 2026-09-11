<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class TenantAwareCompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $inner,
        private readonly RequestStack $requestStack,
    ) {
    }

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
