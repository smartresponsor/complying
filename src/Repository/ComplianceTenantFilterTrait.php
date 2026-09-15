<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * Provides persistence queries for compliance tenant filter trait records used by compliance workflows.
 */
trait ComplianceTenantFilterTrait
{
    private ?string $tenantId = null;

    /**
     * Performs the with tenant behavior as part of the owning compliance responsibility.
     */
    public function withTenant(?string $tenantId): static
    {
        $clone = clone $this;
        $clone->tenantId = $tenantId;

        return $clone;
    }

    /**
     * Performs the apply tenant behavior as part of the owning compliance responsibility.
     */
    protected function applyTenant(QueryBuilder $qb, string $alias = 'c'): void
    {
        if (null !== $this->tenantId && '' !== $this->tenantId) {
            $qb->andWhere($alias.'.tenantId = :tenantId')->setParameter('tenantId', $this->tenantId);
        }
    }
}
