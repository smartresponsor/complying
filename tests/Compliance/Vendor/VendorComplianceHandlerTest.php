<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Vendor;

use App\Complying\Handler\Vendor\ComplianceVendorHandler;
use PHPUnit\Framework\TestCase;

final class VendorComplianceHandlerTest extends TestCase
{
    public function testHandlerConstruct(): void
    {
        $service = $this->createMock(\App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface::class);
        $service->method('decide')->willReturn(
            new \App\Complying\DTO\ComplianceDecisionDTO('PERMIT', 'p1', 'v1', [])
        );
        $em = $this->createMock(\Doctrine\ORM\EntityManagerInterface::class);
        $em->expects(self::once())->method('persist')->with(self::isInstanceOf(\App\Complying\Entity\ComplianceDecisionLog::class));
        $em->expects(self::once())->method('flush');
        $writer = new \App\Complying\Service\ComplianceDecisionLogWriter(
            $em,
            $this->createMock(\App\Complying\ServiceInterface\ComplianceCaseQueueServiceInterface::class),
            new \App\Complying\Provider\Tenant\ComplianceTenantProvider(new \Symfony\Component\HttpFoundation\RequestStack()),
        );
        $handler = new ComplianceVendorHandler($service, $writer);
        $handler(['id' => 'v1', 'country' => 'US']);
    }
}
