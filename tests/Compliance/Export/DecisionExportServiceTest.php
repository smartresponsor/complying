<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Export;

use App\Complying\Service\ComplianceDecisionExportService;
use PHPUnit\Framework\TestCase;

final class DecisionExportServiceTest extends TestCase
{
    public function testServiceIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceDecisionExportService::class);

        self::assertFalse($reflection->isAbstract());
    }
}
