<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceRetentionPolicyEntity;
use App\Complying\RepositoryInterface\ComplianceRetentionPolicyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance retention policy repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceRetentionPolicyEntity> */
final class ComplianceRetentionPolicyRepository extends ServiceEntityRepository implements ComplianceRetentionPolicyRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceRetentionPolicyEntity::class);
    }
}
