<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

interface RoleActorResolverInterface
{
    public function getCurrentActorId(): ?string;

    /**
     * @return string[]
     */
    public function getCurrentActorRoles(): array;
}
