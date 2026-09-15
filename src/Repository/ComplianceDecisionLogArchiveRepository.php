<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceDecisionLogArchive;
use App\Complying\RepositoryInterface\ComplianceDecisionLogArchiveRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance decision log archive repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceDecisionLogArchive> */
final class ComplianceDecisionLogArchiveRepository extends ServiceEntityRepository implements ComplianceDecisionLogArchiveRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceDecisionLogArchive::class);
    }
}
