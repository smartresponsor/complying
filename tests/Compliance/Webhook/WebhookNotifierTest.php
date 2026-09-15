<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Webhook;

use App\Complying\Service\ComplianceWebhookNotifier;
use PHPUnit\Framework\TestCase;

final class WebhookNotifierTest extends TestCase
{
    public function testConstruct(): void
    {
        $client = $this->createMock(\Symfony\Contracts\HttpClient\HttpClientInterface::class);
        $notifier = new ComplianceWebhookNotifier($client, 'https://example.com', 'secret');
        $this->assertInstanceOf(ComplianceWebhookNotifier::class, $notifier);
    }
}
