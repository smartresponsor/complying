<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceLimitPolicyEntity;
use App\Complying\RepositoryInterface\ComplianceLimitPolicyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance limit policy repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceLimitPolicyEntity> */
final class ComplianceLimitPolicyRepository extends ServiceEntityRepository implements ComplianceLimitPolicyRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceLimitPolicyEntity::class);
    }
}
