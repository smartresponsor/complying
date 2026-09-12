<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceConfig;
use App\Complying\RepositoryInterface\ComplianceConfigRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance config repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceConfig> */
final class ComplianceConfigRepository extends ServiceEntityRepository implements ComplianceConfigRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceConfig::class);
    }

    /**
     * Returns the get by key value exposed by this compliance responsibility.
     */
    public function getByKey(string $key): ?ComplianceConfig
    {
        return $this->findOneBy(['keyName' => $key]);
    }
}
