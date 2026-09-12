<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceCaseQueue;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Coordinates the compliance case worker service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceCaseWorkerService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * Performs the process behavior as part of the owning compliance responsibility.
     */
    public function process(int $limit = 50): int
    {
        $repo = $this->em->getRepository(ComplianceCaseQueue::class);
        $items = $repo->findBy(['objectState.objectStatus' => 'new'], ['id' => 'ASC'], $limit);

        $processed = 0;
        foreach ($items as $item) {
            /** @var ComplianceCaseQueue $item */
            $item->setStatus('processed');
            $this->em->persist($item);
            $this->logger->info('Compliance case processed', ['id' => $item->getId()]);
            ++$processed;
        }

        if ($processed > 0) {
            $this->em->flush();
        }

        return $processed;
    }
}
