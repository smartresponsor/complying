<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

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

    public function __construct(string $keyName, ?string $value = null, ?string $scope = null)
    {
        $this->keyName = $keyName;
        $this->value = $value;
        $this->scope = $scope;
        $this->initializeObjectAudit();
    }

    public function getKeyName(): string
    {
        return $this->keyName;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->getModifiedAt();
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
        $this->touchModified();
    }

    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
        $this->touchModified();
    }
}
