<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Integration;

use App\Complying\Handler\Order\OrderComplianceHandler;
use PHPUnit\Framework\TestCase;

final class OrderComplianceHandlerTest extends TestCase
{
    public function testHandlerConstructed(): void
    {
        $service = $this->createMock(\App\Complying\ServiceInterface\CompliancePolicyServiceInterface::class);
        $service->method('decide')->willReturn(
            new \App\Complying\DTO\ComplianceDecisionDTO('PERMIT', 'p1', 'v1', [])
        );
        $writer = $this->createMock(\App\Complying\Service\ComplianceDecisionLogWriter::class);
        $handler = new OrderComplianceHandler($service, $writer);

        $handler(['id' => 'o1', 'total' => 100]);
        $this->assertTrue(true);
    }
}
