<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Entity\ComplianceDecisionLog;
use App\Complying\Service\Tenant\TenantProvider;
use App\Complying\ServiceInterface\CaseQueueServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ComplianceDecisionLogWriter
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CaseQueueServiceInterface $caseQueueService,
        private readonly TenantProvider $tenantProvider,
    ) {
    }

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

    public function createCase(ComplianceDecisionDTO $decision, ?string $objectId): void
    {
        $tenantId = $this->tenantProvider->getTenantId();

        $case = $this->caseQueueService->createFromDecision($decision, $objectId);
        $case->setTenantId($tenantId);

        $this->em->persist($case);
        $this->em->flush();
    }
}
