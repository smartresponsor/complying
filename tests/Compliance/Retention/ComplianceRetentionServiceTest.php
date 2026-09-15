<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Retention;

use App\Complying\Service\ComplianceRetentionService;
use PHPUnit\Framework\TestCase;

final class ComplianceRetentionServiceTest extends TestCase
{
    public function testServiceIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceRetentionService::class);

        self::assertFalse($reflection->isAbstract());
    }
}
