<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceAuditLog;
use App\Complying\RepositoryInterface\ComplianceAuditLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance audit log repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceAuditLog> */
final class ComplianceAuditLogRepository extends ServiceEntityRepository implements ComplianceAuditLogRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceAuditLog::class);
    }
}
