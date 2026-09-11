<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\CompliancePolicyRegistry;

use App\Complying\Entity\CompliancePolicyRegistry;
use PHPUnit\Framework\TestCase;

final class PolicyRegistryEntityTest extends TestCase
{
    public function testCreate(): void
    {
        $e = new CompliancePolicyRegistry('p1', 'v1', 'desc', 'role');
        $this->assertSame('p1', $e->getPolicyId());
        $this->assertSame('v1', $e->getPolicyVersion());
    }
}
