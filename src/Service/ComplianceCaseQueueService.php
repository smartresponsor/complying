<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Entity\ComplianceCaseQueue;
use App\Complying\ServiceInterface\ComplianceCaseQueueServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance case queue service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceCaseQueueService implements ComplianceCaseQueueServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the create from decision behavior as part of the owning compliance responsibility.
     */
    public function createFromDecision(ComplianceDecisionDTO $decision, ?string $objectId): ComplianceCaseQueue
    {
        $case = new ComplianceCaseQueue();
        $case->setStatus('new');
        $case->setPayload($decision->facts);
        $case->setObjectId($objectId);

        $this->em->persist($case);
        $this->em->flush();

        return $case;
    }

    /**
     * Performs the list open behavior as part of the owning compliance responsibility.
     */
    public function listOpen(): array
    {
        return $this->em->getRepository(ComplianceCaseQueue::class)->findBy(['objectState.objectStatus' => 'new'], ['id' => 'DESC'], 200);
    }

    /**
     * Performs the close behavior as part of the owning compliance responsibility.
     */
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
