<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Symfony\Component\HttpFoundation\Request;

final class TenantResolver
{
    public function __construct(
        private readonly string $headerName = 'X-Tenant-ID',
    ) {
    }

    public function resolve(Request $request): ?string
    {
        $h = $request->headers->get($this->headerName);
        if (\is_string($h) && '' !== $h) {
            return $h;
        }

        return $request->attributes->get('_tenant_id');
    }
}
