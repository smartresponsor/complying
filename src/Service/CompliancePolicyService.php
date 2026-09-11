<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\DTO\PolicyFactSet;
use App\Complying\Mapper\FactMapper;
use App\Complying\Service\Policy\RolePolicyClient;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class CompliancePolicyService implements CompliancePolicyServiceInterface
{
    public function __construct(
        private readonly RolePolicyClient $client,
        private readonly FactMapper $factMapper,
    ) {
    }

    public function decide(string $eventName, array $payload): ComplianceDecisionDTO
    {
        $facts = $this->factMapper->map($eventName, $payload);

        $factSet = PolicyFactSet::fromEvent($eventName, $facts);
        $decision = $this->client->decide($factSet);

        $outcome = $decision->outcome;
        if ('PERMIT_WITH_OBLIGATION' === $outcome) {
            $outcome = 'REVIEW';
        }

        return new ComplianceDecisionDTO(
            $outcome,
            $decision->policyId,
            $decision->policyVersion,
            $facts
        );
    }
}
