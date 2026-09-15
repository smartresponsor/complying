<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Dlp;

use App\Complying\Service\ComplianceDlpRedactor;
use PHPUnit\Framework\TestCase;

final class DlpRedactorTest extends TestCase
{
    public function testRedactString(): void
    {
        $dlp = new ComplianceDlpRedactor();
        $out = $dlp->redactString('john.doe@example.com +1 713 555 0101 4111111111111111');
        $this->assertStringNotContainsString('example.com', $out);
        $this->assertStringNotContainsString('4111111111111111', $out);
    }
}
