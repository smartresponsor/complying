<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Tests\Compliance\Vendor;

use App\Integration\Compliance\Vendor\VendorComplianceHandler;
use PHPUnit\Framework\TestCase;

final class VendorComplianceHandlerTest extends TestCase
{
    public function testHandlerConstruct(): void
    {
        $service = $this->createMock(\App\ServiceInterface\Compliance\CompliancePolicyServiceInterface::class);
        $service->method('decide')->willReturn(
            new \App\Service\Compliance\ComplianceDecisionDto('PERMIT', 'p1', 'v1', [])
        );
        $writer = $this->createMock(\App\Service\Compliance\ComplianceDecisionLogWriter::class);
        $handler = new VendorComplianceHandler($service, $writer);
        $handler(['id' => 'v1', 'country' => 'US']);
        $this->assertTrue(true);
    }
}
