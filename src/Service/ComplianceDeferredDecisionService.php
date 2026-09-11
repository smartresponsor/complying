<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Message\ComplianceDecisionMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ComplianceDeferredDecisionService
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function defer(string $eventName, array $payload): void
    {
        $this->bus->dispatch(new ComplianceDecisionMessage($eventName, $payload));
        $this->logger->warning('Compliance decision deferred', ['event' => $eventName]);
    }
}
