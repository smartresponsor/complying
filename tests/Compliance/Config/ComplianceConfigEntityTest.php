<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Config;

use App\Complying\Entity\ComplianceConfig;
use PHPUnit\Framework\TestCase;

final class ComplianceConfigEntityTest extends TestCase
{
    public function testCreate(): void
    {
        $cfg = new ComplianceConfig('k1', 'v1', 'global');
        $this->assertSame('k1', $cfg->getKeyName());
        $this->assertSame('v1', $cfg->getValue());
    }
}
