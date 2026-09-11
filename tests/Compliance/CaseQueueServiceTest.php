<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance;

use PHPUnit\Framework\TestCase;

final class CaseQueueServiceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(\App\Complying\ServiceInterface\CaseQueueServiceInterface::class));
    }
}
