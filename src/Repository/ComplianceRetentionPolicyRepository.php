<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceRetentionPolicy;
use App\Complying\RepositoryInterface\ComplianceRetentionPolicyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ComplianceRetentionPolicyRepository extends ServiceEntityRepository implements ComplianceRetentionPolicyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceRetentionPolicy::class);
    }
}
