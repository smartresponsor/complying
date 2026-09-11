<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Ops;

use App\Complying\Service\Metrics\MetricsExporter;
use PHPUnit\Framework\TestCase;

final class MetricsExporterTest extends TestCase
{
    public function testCollectReturnsString(): void
    {
        $conn = $this->createMock(\Doctrine\DBAL\Connection::class);
        $conn->method('fetchOne')->willReturn(0);

        $exporter = new MetricsExporter($conn);
        $out = $exporter->collect();

        $this->assertIsString($out);
        $this->assertStringContainsString('sr_compliance_decisions_total', $out);
    }
}
