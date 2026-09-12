<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Ui;

use App\Complying\Controller\ComplianceCaseUiController;
use PHPUnit\Framework\TestCase;

final class ComplianceUiExistsTest extends TestCase
{
    public function testComplianceUiControllerIsConcrete(): void
    {
        $reflection = new \ReflectionClass(ComplianceCaseUiController::class);

        self::assertFalse($reflection->isAbstract());
    }
}
