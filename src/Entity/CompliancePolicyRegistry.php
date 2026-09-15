<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance policy registry concept and protects its compliance workflow invariants.
 */
#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\CompliancePolicyRegistryRepository')]
#[ORM\Table(name: 'compliance_policy_registry')]
#[ORM\UniqueConstraint(name: 'uniq_compliance_policy_registry_policy', columns: ['policy_id'])]
class CompliancePolicyRegistry
{
    use ObjectAuditEmbeddableTrait;

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

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(string $policyId, string $policyVersion, ?string $description = null, ?string $source = null)
    {
        $this->policyId = $policyId;
        $this->policyVersion = $policyVersion;
        $this->description = $description;
        $this->source = $source;
        $this->initializeObjectAudit();
    }

    /**
     * Updates the set from value while preserving the owning compliance invariant.
     */
    public function setFrom(string $version, ?string $description, ?string $source): void
    {
        $this->policyVersion = $version;
        $this->description = $description;
        $this->source = $source;
        $this->touchModified();
    }

    /**
     * Returns the get policy id value exposed by this compliance responsibility.
     */
    public function getPolicyId(): string
    {
        return $this->policyId;
    }

    /**
     * Returns the get policy version value exposed by this compliance responsibility.
     */
    public function getPolicyVersion(): string
    {
        return $this->policyVersion;
    }

    /**
     * Returns the get description value exposed by this compliance responsibility.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Returns the get source value exposed by this compliance responsibility.
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * Returns the get updated at value exposed by this compliance responsibility.
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->getModifiedAt();
    }
}
