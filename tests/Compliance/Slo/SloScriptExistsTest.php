<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Slo;

use PHPUnit\Framework\TestCase;

final class SloScriptExistsTest extends TestCase
{
    public function testExists(): void
    {
        $this->assertTrue(file_exists(__DIR__.'/../../../tools/slo/compliance_slo_check.php'));
    }
}
