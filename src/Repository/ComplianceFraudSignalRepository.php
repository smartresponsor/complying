<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceFraudSignal;
use App\Complying\RepositoryInterface\ComplianceFraudSignalRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance fraud signal repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceFraudSignal> */
final class ComplianceFraudSignalRepository extends ServiceEntityRepository implements ComplianceFraudSignalRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceFraudSignal::class);
    }
}
