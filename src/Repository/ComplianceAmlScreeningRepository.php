<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceAmlScreening;
use App\Complying\RepositoryInterface\ComplianceAmlScreeningRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceAmlScreeningRepository extends ServiceEntityRepository implements ComplianceAmlScreeningRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceAmlScreening::class);
    }
}
