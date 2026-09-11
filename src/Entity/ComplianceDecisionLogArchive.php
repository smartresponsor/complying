<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceDecisionLogArchiveRepository')]
#[ORM\Table(name: 'compliance_decision_log_archive')]
class ComplianceDecisionLogArchive
{
    use ObjectAuditEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'json')]
    private array $payload = [];

    public function __construct(array $payload)
    {
        $this->payload = $payload;
        $this->initializeObjectAudit();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getArchivedAt(): \DateTimeImmutable
    {
        return $this->getCreatedAt();
    }
}
