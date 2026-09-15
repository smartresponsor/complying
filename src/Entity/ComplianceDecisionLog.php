<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance decision log concept and protects its compliance workflow invariants.
 */
#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceDecisionLogRepository')]
#[ORM\Table(name: 'compliance_decision_log')]
#[ORM\Index(columns: ['outcome'], name: 'idx_compliance_decision_log_outcome')]
#[ORM\Index(columns: ['tenant_id'], name: 'idx_compliance_decision_log_tenant')]
#[ORM\Index(columns: ['decided_at'], name: 'idx_compliance_decision_log_decided_at')]
class ComplianceDecisionLog
{
    use ObjectAuditEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 128)]
    private string $eventName;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $policyId = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $policyVersion = null;

    #[ORM\Column(type: 'string', length: 32)]
    private string $outcome;

    /** @var array<string, mixed> */
    #[ORM\Column(type: 'json')]
    private array $facts = [];

    #[ORM\Column(name: 'target_id', type: 'string', length: 128, nullable: true)]
    private ?string $targetId = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $tenantId = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $decidedAt;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $facts
     */
    public function __construct(
        string $outcome,
        array $facts,
        ?string $policyId = null,
        ?string $policyVersion = null,
        ?string $targetId = null,
        ?string $tenantId = null,
        ?string $eventName = null,
    ) {
        $this->outcome = $outcome;
        $this->facts = $facts;
        $this->policyId = $policyId;
        $this->policyVersion = $policyVersion;
        $this->targetId = $targetId;
        $this->tenantId = $tenantId;
        $this->eventName = $eventName ?? 'compliance.decision';
        $this->decidedAt = new \DateTimeImmutable('now');
        $this->initializeObjectAudit($this->decidedAt);
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the get event name value exposed by this compliance responsibility.
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * Returns the get outcome value exposed by this compliance responsibility.
     */
    public function getOutcome(): string
    {
        return $this->outcome;
    }

    /**
     * Returns the get policy id value exposed by this compliance responsibility.
     */
    public function getPolicyId(): ?string
    {
        return $this->policyId;
    }

    /**
     * Returns the get policy version value exposed by this compliance responsibility.
     */
    public function getPolicyVersion(): ?string
    {
        return $this->policyVersion;
    }

    /**
     * Returns the get object id value exposed by this compliance responsibility.
     */
    public function getTargetId(): ?string
    {
        return $this->targetId;
    }

    /**
     * Returns the get tenant id value exposed by this compliance responsibility.
     */
    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    /**
     * Returns the get facts value exposed by this compliance responsibility.
     *
     * @return array<string, mixed> */
    public function getFacts(): array
    {
        return $this->facts;
    }

    /**
     * Returns the get decided at value exposed by this compliance responsibility.
     */
    public function getDecidedAt(): \DateTimeImmutable
    {
        return $this->decidedAt;
    }
}
