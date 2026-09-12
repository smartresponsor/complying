<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use App\Objecting\EntityTrait\Embeddable\ObjectStateEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance case queue concept and protects its compliance workflow invariants.
 */
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

    /** @var array<string, mixed> */
    #[ORM\Column(type: 'json')]
    private array $payload = [];

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $objectId = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $tenantId = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $processedAt = null;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(?ComplianceDecisionLog $decision = null)
    {
        $this->decision = $decision;
        $this->initializeObjectAudit();
        $this->initializeObjectState(objectStatus: 'new');
    }

    /**
     * Updates the set status value while preserving the owning compliance invariant.
     */
    public function setStatus(string $status): void
    {
        $this->setObjectStatus($status);
    }

    /**
     * Performs the mark processed behavior as part of the owning compliance responsibility.
     */
    public function markProcessed(?\DateTimeImmutable $processedAt = null): void
    {
        $this->processedAt = $processedAt ?? new \DateTimeImmutable('now');
        $this->setStatus('processed');
        $this->touchModified($this->processedAt);
    }

    /**
     * Performs the close behavior as part of the owning compliance responsibility.
     */
    public function close(string $actor): void
    {
        $this->processedAt = new \DateTimeImmutable('now');
        $this->setStatus('closed');
        $this->touchModified($this->processedAt, $actor);
    }

    /**
     * Updates the set decision value while preserving the owning compliance invariant.
     */
    public function setDecision(?ComplianceDecisionLog $decision): void
    {
        $this->decision = $decision;
    }

    /**
     * Updates the set payload value while preserving the owning compliance invariant.
     *
     * @param array<string, mixed> $payload */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * Updates the set object id value while preserving the owning compliance invariant.
     */
    public function setObjectId(?string $objectId): void
    {
        $this->objectId = $objectId;
    }

    /**
     * Updates the set tenant id value while preserving the owning compliance invariant.
     */
    public function setTenantId(?string $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        if (!isset($this->id)) {
            throw new \LogicException('Compliance case identifier is unavailable before persistence.');
        }

        return $this->id;
    }

    /**
     * Returns the get decision value exposed by this compliance responsibility.
     */
    public function getDecision(): ?ComplianceDecisionLog
    {
        return $this->decision;
    }

    /**
     * Returns the get status value exposed by this compliance responsibility.
     */
    public function getStatus(): string
    {
        $status = $this->getObjectStatus();
        if (null === $status) {
            throw new \LogicException('Compliance case status must be initialized.');
        }

        return $status;
    }

    /**
     * Returns the get payload value exposed by this compliance responsibility.
     *
     * @return array<string, mixed> */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * Returns the get object id value exposed by this compliance responsibility.
     */
    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    /**
     * Returns the get tenant id value exposed by this compliance responsibility.
     */
    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    /**
     * Returns the get processed at value exposed by this compliance responsibility.
     */
    public function getProcessedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }
}
