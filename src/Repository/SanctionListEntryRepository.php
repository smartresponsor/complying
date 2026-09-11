<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceSanctionListEntry;
use App\Complying\RepositoryInterface\SanctionListEntryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class SanctionListEntryRepository extends ServiceEntityRepository implements SanctionListEntryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceSanctionListEntry::class);
    }

    public function existsByName(string $nameEntity): bool
    {
        return (bool) $this->createQueryBuilder('s')
            ->select('1')
            ->andWhere('s.nameEntity = :nameEntity')
            ->setParameter('nameEntity', $nameEntity)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
