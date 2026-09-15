<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceIncidentWebhook;
use App\Complying\RepositoryInterface\ComplianceIncidentWebhookRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Provides persistence queries for compliance incident webhook repository records used by compliance workflows.
 *
 * @extends ServiceEntityRepository<ComplianceIncidentWebhook> */
final class ComplianceIncidentWebhookRepository extends ServiceEntityRepository implements ComplianceIncidentWebhookRepositoryInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceIncidentWebhook::class);
    }

    /**
     * Performs the find pending behavior as part of the owning compliance responsibility.
     *
     * @return ComplianceIncidentWebhook[]
     */
    public function findPending(int $limit = 20): array
    {
        return $this->findBy([], ['id' => 'ASC'], $limit);
    }
}
