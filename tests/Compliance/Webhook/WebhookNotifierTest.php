<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Webhook;

use App\Complying\Service\WebhookNotifier;
use PHPUnit\Framework\TestCase;

final class WebhookNotifierTest extends TestCase
{
    public function testConstruct(): void
    {
        $client = $this->createMock(\Symfony\Contracts\HttpClient\HttpClientInterface::class);
        $notifier = new WebhookNotifier($client, 'https://example.com', 'secret');
        $this->assertInstanceOf(WebhookNotifier::class, $notifier);
    }
}
