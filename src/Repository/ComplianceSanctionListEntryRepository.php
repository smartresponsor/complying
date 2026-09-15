<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceSanctionListEntry;
use App\Complying\RepositoryInterface\ComplianceSanctionListEntryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance sanction list entry repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceSanctionListEntry> */
final class ComplianceSanctionListEntryRepository extends ServiceEntityRepository implements ComplianceSanctionListEntryRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceSanctionListEntry::class);
    }

    /**
     * Performs the exists by name behavior as part of the owning compliance responsibility.
     */
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
