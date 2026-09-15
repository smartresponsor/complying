<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Resolver\ComplianceSecurityRoleActorResolver;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;

/**
 * Coordinates the compliance role aware policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRoleAwarePolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $inner,
        private readonly ComplianceSecurityRoleActorResolver $roleResolver,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
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
