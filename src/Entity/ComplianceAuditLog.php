<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use App\Objecting\EntityTrait\Embeddable\ObjectAuditEmbeddableTrait;
use Doctrine\ORM\Mapping as ORM;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getActor(): ?string
    {
        return $this->actor;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    /** @return array<string, mixed> */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
