<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Reporting;

use App\Complying\Controller\ComplianceReportingController;
use PHPUnit\Framework\TestCase;

final class ReportingControllerExistsTest extends TestCase
{
    public function testControllerIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceReportingController::class);

        self::assertFalse($reflection->isAbstract());
    }
}
