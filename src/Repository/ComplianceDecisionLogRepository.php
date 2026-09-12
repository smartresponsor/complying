<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceDecisionLog;
use App\Complying\RepositoryInterface\ComplianceDecisionLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance decision log repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceDecisionLog> */
final class ComplianceDecisionLogRepository extends ServiceEntityRepository implements ComplianceDecisionLogRepositoryInterface
{
    use ComplianceTenantFilterTrait;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceDecisionLog::class);
    }
}
