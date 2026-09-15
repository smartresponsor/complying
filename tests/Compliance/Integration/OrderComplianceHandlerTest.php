<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Integration;

use App\Complying\Handler\Order\ComplianceOrderHandler;
use PHPUnit\Framework\TestCase;

final class OrderComplianceHandlerTest extends TestCase
{
    public function testHandlerConstructed(): void
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
        $handler = new ComplianceOrderHandler($service, $writer);

        $handler(['id' => 'o1', 'total' => 100]);
    }
}
