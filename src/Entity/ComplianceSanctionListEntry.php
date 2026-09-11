<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\SanctionListEntryRepository')]
#[ORM\Table(name: 'compliance_sanction_list_entry')]
class ComplianceSanctionListEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nameEntity;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $listSource = null;

    public function __construct(string $nameEntity, ?string $listSource = null)
    {
        $this->nameEntity = $nameEntity;
        $this->listSource = $listSource;
    }

    public function getName(): string
    {
        return $this->nameEntity;
    }
}
