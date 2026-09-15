<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Message\ComplianceIncidentCreated;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Coordinates the compliance messenger policy evaluation service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceMessengerPolicyEvaluationService implements CompliancePolicyEvaluationServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $inner,
        private readonly MessageBusInterface $bus,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $decision = $this->inner->decide($eventName, $payload);

        if (\in_array($decision->outcome, ['DENY', 'REVIEW'], true)) {
            $this->bus->dispatch(new ComplianceIncidentCreated(
                $eventName,
                $decision->outcome,
                $payload['id'] ?? null,
                $decision->facts,
            ));
        }

        return $decision;
    }
}
