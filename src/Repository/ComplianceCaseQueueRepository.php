<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceCaseQueue;
use App\Complying\RepositoryInterface\ComplianceCaseQueueRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance case queue repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceCaseQueue> */
final class ComplianceCaseQueueRepository extends ServiceEntityRepository implements ComplianceCaseQueueRepositoryInterface
{
    use ComplianceTenantFilterTrait;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceCaseQueue::class);
    }
}
