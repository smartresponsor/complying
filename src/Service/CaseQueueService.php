<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Entity\ComplianceCaseQueue;
use App\Complying\ServiceInterface\CaseQueueServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class CaseQueueService implements CaseQueueServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function createFromDecision(ComplianceDecisionDTO $decision, ?string $objectId): ComplianceCaseQueue
    {
        $case = new ComplianceCaseQueue();
        $case->setStatus('new');
        $case->setSourceDecisionId($decision->policyId);
        $case->setPayload($decision->facts);
        $case->setObjectId($objectId);

        $this->em->persist($case);
        $this->em->flush();

        return $case;
    }

    public function listOpen(): array
    {
        return $this->em->getRepository(ComplianceCaseQueue::class)->findBy(['status' => 'new'], ['id' => 'DESC'], 200);
    }

    public function close(int $id, string $actor): void
    {
        $case = $this->em->find(ComplianceCaseQueue::class, $id);
        if (!$case) {
            return;
        }
        $case->close($actor);
        $this->em->flush();
    }
}
