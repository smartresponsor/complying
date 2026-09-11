<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service\Tenant;

use Symfony\Component\HttpFoundation\RequestStack;

final class TenantProvider
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getTenantId(): ?string
    {
        $req = $this->requestStack->getCurrentRequest();
        if (!$req) {
            return null;
        }

        return $req->headers->get('X-Tenant') ?? $req->query->get('tenant_id');
    }
}
