<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

/**
 * Defines the behavioral contract for compliance role actor resolver interface collaborators in the compliance component.
 */
interface ComplianceRoleActorResolverInterface
{
    /**
     * Returns the get current actor id value exposed by this compliance responsibility.
     */
    public function getCurrentActorId(): ?string;

    /**
     * Returns the get current actor roles value exposed by this compliance responsibility.
     *
     * @return string[]
     */
    public function getCurrentActorRoles(): array;
}
