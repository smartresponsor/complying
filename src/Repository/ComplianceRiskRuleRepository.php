<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceRiskRule;
use App\Complying\RepositoryInterface\ComplianceRiskRuleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceRiskRuleRepository extends ServiceEntityRepository implements ComplianceRiskRuleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceRiskRule::class);
    }
}
