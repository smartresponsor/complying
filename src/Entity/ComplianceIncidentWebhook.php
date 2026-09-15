<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance incident webhook concept and protects its compliance workflow invariants.
 */
#[ORM\Entity(repositoryClass: 'App\Complying\\Repository\\ComplianceIncidentWebhookRepository')]
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

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $payload */
    public function __construct(string $url, array $payload)
    {
        $this->url = $url;
        $this->payload = json_encode($payload, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR);
        $this->createdAt = new \DateTimeImmutable('now');
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the get url value exposed by this compliance responsibility.
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns the get payload value exposed by this compliance responsibility.
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * Returns the get attempts value exposed by this compliance responsibility.
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * Returns the get created at value exposed by this compliance responsibility.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Performs the inc attempts behavior as part of the owning compliance responsibility.
     */
    public function incAttempts(): void
    {
        ++$this->attempts;
    }
}
