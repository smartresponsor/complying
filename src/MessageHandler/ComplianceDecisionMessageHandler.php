<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\MessageHandler;

use App\Complying\Message\ComplianceDecisionMessage;
use App\Complying\Service\ComplianceDecisionLogWriter;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;
use Symfony\Component\Messenger\CommerceAttributeEntity\AsMessageHandler;

#[AsMessageHandler]
final class ComplianceDecisionMessageHandler
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $service,
        private readonly ComplianceDecisionLogWriter $logWriter,
    ) {
    }

    public function __invoke(ComplianceDecisionMessage $message): void
    {
        $payload = $message->getPayload();
        $decision = $this->service->decide($message->getEventName(), $payload);
        $objectId = $payload['id'] ?? null;

        $this->logWriter->write($decision, $objectId, $message->getEventName());

        if ('REVIEW' === $decision->outcome) {
            $this->logWriter->createCase($decision, $objectId);
        }
    }
}
