<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'compliance_retention_policy')]
class ComplianceRetentionPolicy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 120)]
    private string $resource;

    #[ORM\Column(type: 'integer')]
    private int $days;

    public function __construct(string $resource, int $days)
    {
        $this->resource = $resource;
        $this->days = $days;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function getDays(): int
    {
        return $this->days;
    }

    public function setDays(int $days): void
    {
        $this->days = $days;
    }
}
