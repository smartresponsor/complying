<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use App\Complying\Entity\ComplianceIncidentWebhook;
use App\Complying\RepositoryInterface\IncidentWebhookRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class IncidentWebhookRepository extends ServiceEntityRepository implements IncidentWebhookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplianceIncidentWebhook::class);
    }

    /**
     * @return ComplianceIncidentWebhook[]
     */
    public function findPending(int $limit = 20): array
    {
        return $this->findBy([], ['id' => 'ASC'], $limit);
    }
}
