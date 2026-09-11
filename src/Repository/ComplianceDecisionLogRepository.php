<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceDecisionLog;
use App\Complying\RepositoryInterface\ComplianceDecisionLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceDecisionLogRepository extends ServiceEntityRepository implements ComplianceDecisionLogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceDecisionLog::class);
    }
}
