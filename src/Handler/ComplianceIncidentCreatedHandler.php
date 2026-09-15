<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Handler;

use App\Complying\Message\ComplianceIncidentCreated;
use App\Complying\Service\ComplianceWebhookNotifier;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Coordinates the compliance incident created handler responsibility within the Complying component and its explicit boundaries.
 */
#[AsMessageHandler(handles: ComplianceIncidentCreated::class)]
final class ComplianceIncidentCreatedHandler
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ?ComplianceWebhookNotifier $notifier = null,
    ) {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    public function __invoke(ComplianceIncidentCreated $msg): void
    {
        $this->logger->info('Compliance incident created', [
            'event' => $msg->eventName,
            'outcome' => $msg->outcome,
            'object_id' => $msg->objectId,
        ]);

        if ($this->notifier) {
            $this->notifier->send([
                'event' => $msg->eventName,
                'outcome' => $msg->outcome,
                'object_id' => $msg->objectId,
                'facts' => $msg->facts,
                'via' => 'bus',
            ]);
        }
    }
}
