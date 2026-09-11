<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\ServiceInterface\RoleActorResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class SecurityRoleActorResolver implements RoleActorResolverInterface
{
    public function __construct(private readonly TokenStorageInterface $tokenStorage)
    {
    }

    public function getCurrentActorId(): ?string
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return null;
        }
        $user = $token->getUser();
        if (\is_object($user) && method_exists($user, 'getUserIdentifier')) {
            return (string) $user->getUserIdentifier();
        }
        if (\is_string($user)) {
            return $user;
        }

        return null;
    }

    public function getCurrentActorRoles(): array
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return [];
        }

        return array_values($token->getRoleNames());
    }
}
