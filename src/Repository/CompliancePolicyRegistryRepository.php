<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\CompliancePolicyRegistry;
use App\Complying\RepositoryInterface\CompliancePolicyRegistryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance policy registry repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<CompliancePolicyRegistry> */
final class CompliancePolicyRegistryRepository extends ServiceEntityRepository implements CompliancePolicyRegistryRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompliancePolicyRegistry::class);
    }

    /**
     * Performs the find one by policy id behavior as part of the owning compliance responsibility.
     */
    public function findOneByPolicyId(string $policyId): ?CompliancePolicyRegistry
    {
        return $this->findOneBy(['policyId' => $policyId]);
    }
}
