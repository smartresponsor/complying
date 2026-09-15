<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance audit log concept and protects its compliance workflow invariants.
 */
#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceAuditLogRepository')]
#[ORM\Table(name: 'compliance_audit_log')]
#[ORM\Index(columns: ['action'], name: 'idx_compliance_audit_log_action')]
class ComplianceAuditLog
{
    use ObjectAuditEmbeddableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 64)]
    private string $action;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $actor = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $ip = null;

    /** @var array<string, mixed> */
    #[ORM\Column(type: 'json')]
    private array $payload = [];

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function __construct(string $action, ?string $actor, ?string $ip, array $payload)
    {
        $this->action = $action;
        $this->actor = $actor;
        $this->ip = $ip;
        $this->payload = $payload;
        $this->initializeObjectAudit(new \DateTimeImmutable('now'), $actor);
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the get action value exposed by this compliance responsibility.
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Returns the get actor value exposed by this compliance responsibility.
     */
    public function getActor(): ?string
    {
        return $this->actor;
    }

    /**
     * Returns the get ip value exposed by this compliance responsibility.
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * Returns the get payload value exposed by this compliance responsibility.
     *
     * @return array<string, mixed> */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
