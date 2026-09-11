<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\MessageHandler;

use App\Complying\Message\ComplianceIncidentCreated;
use App\Complying\Service\WebhookNotifier;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\CommerceAttributeEntity\AsMessageHandler;

#[AsMessageHandler(handles: ComplianceIncidentCreated::class)]
final class ComplianceIncidentCreatedHandler
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ?WebhookNotifier $notifier = null,
    ) {
    }

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
