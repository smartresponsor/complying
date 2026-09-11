<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\IncidentWebhookRepository')]
#[ORM\Table(name: 'compliance_incident_webhook')]
class ComplianceIncidentWebhook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $payload;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'smallint')]
    private int $attempts = 0;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(string $url, array $payload)
    {
        $this->url = $url;
        $this->payload = json_encode($payload, \JSON_UNESCAPED_UNICODE);
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function incAttempts(): void
    {
        ++$this->attempts;
    }
}
