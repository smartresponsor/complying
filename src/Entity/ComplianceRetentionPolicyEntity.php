<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance retention policy entity concept and protects its compliance workflow invariants.
 */
#[ORM\Entity]
#[ORM\Table(name: 'compliance_retention_policy')]
class ComplianceRetentionPolicyEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 120)]
    private string $resource;

    #[ORM\Column(type: 'integer')]
    private int $days;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(string $resource, int $days)
    {
        $this->resource = $resource;
        $this->days = $days;
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the get resource value exposed by this compliance responsibility.
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * Returns the get days value exposed by this compliance responsibility.
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * Updates the set days value while preserving the owning compliance invariant.
     */
    public function setDays(int $days): void
    {
        $this->days = $days;
    }
}
