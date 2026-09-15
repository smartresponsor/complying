<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance decision log archive concept and protects its compliance workflow invariants.
 */
#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceDecisionLogArchiveRepository')]
#[ORM\Table(name: 'compliance_decision_log_archive')]
class ComplianceDecisionLogArchive
{
    use ObjectAuditEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /** @var array<string, mixed> */
    #[ORM\Column(type: 'json')]
    private array $payload = [];

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $payload */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
        $this->initializeObjectAudit();
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        return $this->id;
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
     * Returns the get archived at value exposed by this compliance responsibility.
     */
    public function getArchivedAt(): \DateTimeImmutable
    {
        return $this->getCreatedAt();
    }
}
