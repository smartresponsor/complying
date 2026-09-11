<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class RoleAwareCompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $inner,
        private readonly SecurityRoleActorResolver $roleResolver,
    ) {
    }

    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $actor = $this->roleResolver->getCurrentActorId();
        if ($actor) {
            $payload['actor'] = $actor;
            $payload['actor_roles'] = $this->roleResolver->getCurrentActorRoles();
        }

        $decision = $this->inner->decide($eventName, $payload);
        $decision->facts['actor'] = $payload['actor'] ?? $decision->facts['actor'] ?? null;
        $decision->facts['actor_roles'] = $payload['actor_roles'] ?? $decision->facts['actor_roles'] ?? [];

        return $decision;
    }
}
