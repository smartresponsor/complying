<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Resolver;

use Symfony\Component\HttpFoundation\Request;

/**
 * Coordinates the compliance tenant resolver responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceTenantResolver
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly string $headerName = 'X-Tenant-ID',
    ) {
    }

    /**
     * Performs the resolve behavior as part of the owning compliance responsibility.
     */
    public function resolve(Request $request): ?string
    {
        $h = $request->headers->get($this->headerName);
        if (\is_string($h) && '' !== $h) {
            return $h;
        }

        return $request->attributes->get('_tenant_id');
    }
}
