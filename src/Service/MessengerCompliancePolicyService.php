<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Message\ComplianceIncidentCreated;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $inner,
        private readonly MessageBusInterface $bus,
    ) {
    }

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
