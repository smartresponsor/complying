<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Provider\Tenant;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Coordinates the compliance tenant provider responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceTenantProvider
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * Returns the get tenant id value exposed by this compliance responsibility.
     */
    public function getTenantId(): ?string
    {
        $req = $this->requestStack->getCurrentRequest();
        if (!$req) {
            return null;
        }

        return $req->headers->get('X-Tenant') ?? $req->query->get('tenant_id');
    }
}
