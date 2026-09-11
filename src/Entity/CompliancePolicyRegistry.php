<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use App\Objecting\EntityTrait\Embeddable\ObjectVersionEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\PolicyRegistryRepository')]
#[ORM\Table(name: 'compliance_policy_registry')]
#[ORM\UniqueConstraint(name: 'uniq_compliance_policy_registry_policy', columns: ['policy_id'])]
class CompliancePolicyRegistry
{
    use ObjectAuditEmbeddableTrait;
    use ObjectVersionEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 128)]
    private string $policyId;

    #[ORM\Column(type: 'string', length: 64)]
    private string $policyVersion;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $source = null;

    public function __construct(string $policyId, string $policyVersion, ?string $description = null, ?string $source = null)
    {
        $this->policyId = $policyId;
        $this->policyVersion = $policyVersion;
        $this->description = $description;
        $this->source = $source;
        $this->initializeObjectAudit();
        $this->initializeObjectVersion($policyVersion);
    }

    public function setFrom(string $version, ?string $description, ?string $source): void
    {
        $this->policyVersion = $version;
        $this->description = $description;
        $this->source = $source;
        $this->setObjectVersion($version);
        $this->touchModified();
    }

    public function getPolicyId(): string
    {
        return $this->policyId;
    }

    public function getPolicyVersion(): string
    {
        return $this->policyVersion;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->getObjectUpdatedAt();
    }
}
