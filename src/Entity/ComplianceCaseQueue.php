<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use App\Objecting\EntityTrait\Embeddable\ObjectStateEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceCaseQueueRepository')]
#[ORM\Table(name: 'compliance_case_queue')]
#[ORM\Index(columns: ['status'], name: 'idx_compliance_case_queue_status')]
#[ORM\Index(columns: ['tenant_id'], name: 'idx_compliance_case_queue_tenant')]
class ComplianceCaseQueue
{
    use ObjectAuditEmbeddableTrait;
    use ObjectStateEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: ComplianceDecisionLog::class)]
    #[ORM\JoinColumn(name: 'decision_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?ComplianceDecisionLog $decision = null;

    #[ORM\Column(type: 'string', length: 32)]
    private string $status = 'new';

    /** @var array<string, mixed> */
    #[ORM\Column(type: 'json')]
    private array $payload = [];

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $objectId = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $tenantId = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $processedAt = null;

    public function __construct(?ComplianceDecisionLog $decision = null)
    {
        $this->decision = $decision;
        $this->initializeObjectAudit();
        $this->initializeObjectState(objectStatus: $this->status);
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->setObjectStatus($status);
    }

    public function markProcessed(?\DateTimeImmutable $processedAt = null): void
    {
        $this->processedAt = $processedAt ?? new \DateTimeImmutable('now');
        $this->setStatus('processed');
        $this->touchModified($this->processedAt);
    }

    public function setDecision(?ComplianceDecisionLog $decision): void
    {
        $this->decision = $decision;
    }

    public function setSourceDecisionId(?string $sourceDecisionId): void
    { /* Compatibility no-op: use setDecision() for entity-first relation. */
    }

    /** @param array<string, mixed> $payload */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function setObjectId(?string $objectId): void
    {
        $this->objectId = $objectId;
    }

    public function setTenantId(?string $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDecision(): ?ComplianceDecisionLog
    {
        return $this->decision;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /** @return array<string, mixed> */
    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    public function getProcessedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }
}
