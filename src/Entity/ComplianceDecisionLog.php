<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    private ?string $objectId = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $tenantId = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $decidedAt;

    /**
     * @param array<string, mixed> $facts
     */
    public function __construct(
        string $outcome,
        array $facts,
        ?string $policyId = null,
        ?string $policyVersion = null,
        ?string $objectId = null,
        ?string $tenantId = null,
        ?string $eventName = null,
    ) {
        $this->outcome = $outcome;
        $this->facts = $facts;
        $this->policyId = $policyId;
        $this->policyVersion = $policyVersion;
        $this->objectId = $objectId;
        $this->tenantId = $tenantId;
        $this->eventName = $eventName ?? 'compliance.decision';
        $this->decidedAt = new \DateTimeImmutable('now');
        $this->initializeObjectAudit($this->decidedAt);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getOutcome(): string
    {
        return $this->outcome;
    }

    public function getPolicyId(): ?string
    {
        return $this->policyId;
    }

    public function getPolicyVersion(): ?string
    {
        return $this->policyVersion;
    }

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    /** @return array<string, mixed> */
    public function getFacts(): array
    {
        return $this->facts;
    }

    public function getDecidedAt(): \DateTimeImmutable
    {
        return $this->decidedAt;
    }
}
