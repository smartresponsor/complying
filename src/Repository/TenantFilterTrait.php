<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Repository;

use Doctrine\ORM\QueryBuilder;

trait TenantFilterTrait
{
    private ?string $tenantId = null;

    public function withTenant(?string $tenantId): static
    {
        $clone = clone $this;
        $clone->tenantId = $tenantId;

        return $clone;
    }

    protected function applyTenant(QueryBuilder $qb, string $alias = 'c'): void
    {
        if (null !== $this->tenantId && '' !== $this->tenantId) {
            $qb->andWhere($alias.'.tenantId = :tenantId')->setParameter('tenantId', $this->tenantId);
        }
    }
}
