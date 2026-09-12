<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\CaseWorker;

use App\Complying\Service\ComplianceCaseWorkerService;
use PHPUnit\Framework\TestCase;

final class ComplianceCaseWorkerServiceTest extends TestCase
{
    public function testServiceIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceCaseWorkerService::class);

        self::assertFalse($reflection->isAbstract());
    }
}
