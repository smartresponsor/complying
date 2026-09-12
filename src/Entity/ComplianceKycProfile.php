<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance kyc profile concept and protects its compliance workflow invariants.
 */
#[ORM\Entity]
#[ORM\Table(name: 'kyc_profile')]
class ComplianceKycProfile
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $vendorId;

    #[ORM\Column(length: 24)]
    private string $status = 'pending';

    /** @var array<string, mixed>|null */
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $data = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $data */
    public function __construct(int $vendorId, array $data = [])
    {
        $this->vendorId = $vendorId;
        $this->data = $data;
        $this->createdAt = new \DateTimeImmutable();
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
     * Returns the get status value exposed by this compliance responsibility.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Returns the get data value exposed by this compliance responsibility.
     *
     * @return array<string, mixed>|null */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Returns the get created at value exposed by this compliance responsibility.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Performs the mark verified behavior as part of the owning compliance responsibility.
     */
    public function markVerified(): void
    {
        $this->status = 'verified';
    }

    /**
     * Performs the mark rejected behavior as part of the owning compliance responsibility.
     */
    public function markRejected(): void
    {
        $this->status = 'rejected';
    }
}
