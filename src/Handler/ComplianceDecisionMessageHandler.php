<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Handler;

use App\Complying\Message\ComplianceDecisionMessage;
use App\Complying\Service\ComplianceDecisionLogWriter;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Coordinates the compliance decision message handler responsibility within the Complying component and its explicit boundaries.
 */
#[AsMessageHandler]
final class ComplianceDecisionMessageHandler
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $service,
        private readonly ComplianceDecisionLogWriter $logWriter,
    ) {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
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
