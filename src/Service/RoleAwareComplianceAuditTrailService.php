<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;

final class RoleAwareComplianceAuditTrailService implements ComplianceAuditTrailServiceInterface
{
    public function __construct(
        private readonly ComplianceAuditTrailService $inner,
        private readonly SecurityRoleActorResolver $roleResolver,
    ) {
    }

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
