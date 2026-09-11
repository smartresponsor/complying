<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Messenger;

use App\Complying\Message\ComplianceDecisionMessage;
use PHPUnit\Framework\TestCase;

final class ComplianceDecisionMessageTest extends TestCase
{
    public function testCreate(): void
    {
        $msg = new ComplianceDecisionMessage('order.created', ['id' => 'o1']);
        $this->assertSame('order.created', $msg->getEventName());
        $this->assertSame('o1', $msg->getPayload()['id']);
    }
}
