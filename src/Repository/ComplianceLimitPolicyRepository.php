<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceLimitPolicy;
use App\Complying\RepositoryInterface\ComplianceLimitPolicyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceLimitPolicyRepository extends ServiceEntityRepository implements ComplianceLimitPolicyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceLimitPolicy::class);
    }
}
