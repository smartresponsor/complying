<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Resolver\ComplianceSecurityRoleActorResolver;
use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;

/**
 * Coordinates the compliance role aware audit trail service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRoleAwareAuditTrailService implements ComplianceAuditTrailServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceAuditTrailService $inner,
        private readonly ComplianceSecurityRoleActorResolver $roleResolver,
    ) {
    }

    /**
     * Performs the add behavior as part of the owning compliance responsibility.
     */
    public function add(string $action, array $payload = []): void
    {
        $actor = $this->roleResolver->getCurrentActorId();
        if (null !== $actor) {
            $payload['actor'] = $actor;
            $payload['actor_roles'] = $this->roleResolver->getCurrentActorRoles();
        }
        $this->inner->add($action, $payload);
    }
}
