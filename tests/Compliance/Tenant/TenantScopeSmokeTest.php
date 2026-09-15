<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Tenant;

use App\Complying\Provider\Tenant\ComplianceTenantProvider;
use PHPUnit\Framework\TestCase;

final class TenantScopeSmokeTest extends TestCase
{
    public function testTenantProviderIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceTenantProvider::class);

        self::assertFalse($reflection->isAbstract());
    }
}
