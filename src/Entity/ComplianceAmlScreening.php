<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance aml screening concept and protects its compliance workflow invariants.
 */
#[ORM\Entity]
#[ORM\Table(name: 'aml_screening')]
class ComplianceAmlScreening
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $vendorId;

    #[ORM\Column(length: 24)]
    private string $result = 'clear';

    /** @var array<string, mixed>|null */
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $hits = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $screenedAt;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $hits
     */
    public function __construct(int $vendorId, string $result = 'clear', array $hits = [])
    {
        $this->vendorId = $vendorId;
        $this->result = $result;
        $this->hits = $hits;
        $this->screenedAt = new \DateTimeImmutable();
    }

    /**
     * Returns the get id value exposed by this compliance responsibility.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the get vendor id value exposed by this compliance responsibility.
     */
    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    /**
     * Returns the get result value exposed by this compliance responsibility.
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * Returns the get hits value exposed by this compliance responsibility.
     *
     * @return array<string, mixed>|null */
    public function getHits(): ?array
    {
        return $this->hits;
    }

    /**
     * Returns the get screened at value exposed by this compliance responsibility.
     */
    public function getScreenedAt(): \DateTimeImmutable
    {
        return $this->screenedAt;
    }
}
