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

/** @extends ServiceEntityRepository<ComplianceConfig> */
final class ComplianceConfigRepository extends ServiceEntityRepository implements ComplianceConfigRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceConfig::class);
    }

    public function getByKey(string $key): ?ComplianceConfig
    {
        return $this->findOneBy(['keyName' => $key]);
    }
}
