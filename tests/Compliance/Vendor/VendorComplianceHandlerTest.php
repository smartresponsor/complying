<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Vendor;

use App\Complying\Handler\Vendor\VendorComplianceHandler;
use PHPUnit\Framework\TestCase;

final class VendorComplianceHandlerTest extends TestCase
{
    public function testHandlerConstruct(): void
    {
        $service = $this->createMock(\App\Complying\ServiceInterface\CompliancePolicyServiceInterface::class);
        $service->method('decide')->willReturn(
            new \App\Complying\DTO\ComplianceDecisionDTO('PERMIT', 'p1', 'v1', [])
        );
        $writer = new \App\Complying\Service\ComplianceDecisionLogWriter(
            $this->createMock(\Doctrine\ORM\EntityManagerInterface::class),
            $this->createMock(\App\Complying\ServiceInterface\CaseQueueServiceInterface::class),
            new \App\Complying\Service\Tenant\TenantProvider(new \Symfony\Component\HttpFoundation\RequestStack()),
        );
        $handler = new VendorComplianceHandler($service, $writer);
        $handler(['id' => 'v1', 'country' => 'US']);
        $this->assertTrue(true);
    }
}
