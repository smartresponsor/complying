<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Entity\ComplianceDecisionLog;
use App\Complying\Provider\Tenant\ComplianceTenantProvider;
use App\Complying\ServiceInterface\ComplianceCaseQueueServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance decision log writer responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDecisionLogWriter
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ComplianceCaseQueueServiceInterface $caseQueueService,
        private readonly ComplianceTenantProvider $tenantProvider,
    ) {
    }

    /**
     * Performs the write behavior as part of the owning compliance responsibility.
     */
    public function write(ComplianceDecisionDTO $decision, ?string $objectId, string $eventName): void
    {
        $tenantId = $this->tenantProvider->getTenantId();

        $entry = new ComplianceDecisionLog(
            $decision->outcome,
            $decision->facts,
            $decision->policyId,
            $decision->policyVersion,
            $objectId,
            $tenantId,
        );

        $this->em->persist($entry);
        $this->em->flush();
    }

    /**
     * Performs the create case behavior as part of the owning compliance responsibility.
     */
    public function createCase(ComplianceDecisionDTO $decision, ?string $objectId): void
    {
        $tenantId = $this->tenantProvider->getTenantId();

        $case = $this->caseQueueService->createFromDecision($decision, $objectId);
        $case->setTenantId($tenantId);

        $this->em->persist($case);
        $this->em->flush();
    }
}
