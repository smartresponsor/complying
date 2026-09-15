<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Audit;

use App\Complying\Service\ComplianceAuditTrailService;
use PHPUnit\Framework\TestCase;

final class ComplianceAuditTrailServiceTest extends TestCase
{
    public function testServiceIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceAuditTrailService::class);

        self::assertFalse($reflection->isAbstract());
    }
}
