<?php

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceKycProfile;
use App\Complying\RepositoryInterface\ComplianceKycProfileRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance kyc profile repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceKycProfile> */
final class ComplianceKycProfileRepository extends ServiceEntityRepository implements ComplianceKycProfileRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceKycProfile::class);
    }
}
