<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\MessageBus;

use App\Complying\Message\ComplianceIncidentCreated;
use PHPUnit\Framework\TestCase;

final class ComplianceIncidentCreatedTest extends TestCase
{
    public function testCreate(): void
    {
        $m = new ComplianceIncidentCreated('order.created', 'DENY', 'o-1', []);
        $this->assertSame('DENY', $m->outcome);
    }
}
