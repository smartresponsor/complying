<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\CompliancePolicyRegistry;
use App\Complying\RepositoryInterface\PolicyRegistryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<CompliancePolicyRegistry> */
final class PolicyRegistryRepository extends ServiceEntityRepository implements PolicyRegistryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompliancePolicyRegistry::class);
    }

    public function findOneByPolicyId(string $policyId): ?CompliancePolicyRegistry
    {
        return $this->findOneBy(['policyId' => $policyId]);
    }
}
