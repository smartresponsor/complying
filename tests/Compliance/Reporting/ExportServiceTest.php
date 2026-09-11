<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Reporting;

use App\Complying\Service\ExportService;
use PHPUnit\Framework\TestCase;

final class ExportServiceTest extends TestCase
{
    public function testToCsvEmpty(): void
    {
        $em = $this->createMock(\Doctrine\ORM\EntityManagerInterface::class);
        $svc = new ExportService($em);
        $csv = $svc->toCsv([]);
        $this->assertStringContainsString('id,outcome,policy_id', $csv);
    }
}
