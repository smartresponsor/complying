<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceAmlScreening;
use App\Complying\RepositoryInterface\ComplianceAmlScreeningRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance aml screening repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceAmlScreening> */
final class ComplianceAmlScreeningRepository extends ServiceEntityRepository implements ComplianceAmlScreeningRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceAmlScreening::class);
    }
}
