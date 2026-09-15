<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance config concept and protects its compliance workflow invariants.
 */
#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceConfigRepository')]
#[ORM\Table(name: 'compliance_config')]
#[ORM\UniqueConstraint(name: 'uniq_compliance_config_key_name', columns: ['key_name'])]
class ComplianceConfig
{
    use ObjectAuditEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 128)]
    private string $keyName;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value = null;

    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    private ?string $scope = null;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(string $keyName, ?string $value = null, ?string $scope = null)
    {
        $this->keyName = $keyName;
        $this->value = $value;
        $this->scope = $scope;
        $this->initializeObjectAudit();
    }

    /**
     * Returns the get key name value exposed by this compliance responsibility.
     */
    public function getKeyName(): string
    {
        return $this->keyName;
    }

    /**
     * Returns the get value value exposed by this compliance responsibility.
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Returns the get scope value exposed by this compliance responsibility.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Returns the get updated at value exposed by this compliance responsibility.
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->getModifiedAt();
    }

    /**
     * Updates the set value value while preserving the owning compliance invariant.
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
        $this->touchModified();
    }

    /**
     * Updates the set scope value while preserving the owning compliance invariant.
     */
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
        $this->touchModified();
    }
}
