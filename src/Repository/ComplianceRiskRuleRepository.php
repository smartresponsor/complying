<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceRiskRule;
use App\Complying\RepositoryInterface\ComplianceRiskRuleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance risk rule repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceRiskRule> */
final class ComplianceRiskRuleRepository extends ServiceEntityRepository implements ComplianceRiskRuleRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceRiskRule::class);
    }
}
