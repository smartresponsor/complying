<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Resolver;

use App\Complying\ServiceInterface\ComplianceRoleActorResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Coordinates the compliance security role actor resolver responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceSecurityRoleActorResolver implements ComplianceRoleActorResolverInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly TokenStorageInterface $tokenStorage)
    {
    }

    /**
     * Returns the get current actor id value exposed by this compliance responsibility.
     */
    public function getCurrentActorId(): ?string
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return null;
        }

        return $token->getUser()?->getUserIdentifier();
    }

    /**
     * Returns the get current actor roles value exposed by this compliance responsibility.
     */
    public function getCurrentActorRoles(): array
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return [];
        }

        return array_values($token->getRoleNames());
    }
}
