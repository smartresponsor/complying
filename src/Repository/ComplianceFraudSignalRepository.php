<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceFraudSignal;
use App\Complying\RepositoryInterface\ComplianceFraudSignalRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceFraudSignalRepository extends ServiceEntityRepository implements ComplianceFraudSignalRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceFraudSignal::class);
    }
}
