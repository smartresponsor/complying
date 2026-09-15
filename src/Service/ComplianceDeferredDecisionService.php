<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Message\ComplianceDecisionMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Coordinates the compliance deferred decision service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDeferredDecisionService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * Performs the defer behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function defer(string $eventName, array $payload): void
    {
        $this->bus->dispatch(new ComplianceDecisionMessage($eventName, $payload));
        $this->logger->warning('Compliance decision deferred', ['event' => $eventName]);
    }
}
