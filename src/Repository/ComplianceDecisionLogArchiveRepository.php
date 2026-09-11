<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceDecisionLogArchive;
use App\Complying\RepositoryInterface\ComplianceDecisionLogArchiveRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceDecisionLogArchiveRepository extends ServiceEntityRepository implements ComplianceDecisionLogArchiveRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceDecisionLogArchive::class);
    }
}
