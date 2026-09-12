<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Metrics;

use App\Complying\Service\ComplianceMetricsRegistry;
use PHPUnit\Framework\TestCase;

final class MetricsRegistryTest extends TestCase
{
    public function testExportFormat(): void
    {
        $m = new ComplianceMetricsRegistry();
        $txt = $m->export();
        $this->assertStringContainsString('compliance_decisions_total', $txt);
    }
}
