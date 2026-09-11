<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceCaseQueue;
use App\Complying\RepositoryInterface\ComplianceCaseQueueRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceCaseQueueRepository extends ServiceEntityRepository implements ComplianceCaseQueueRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceCaseQueue::class);
    }
}
