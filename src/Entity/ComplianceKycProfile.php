<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $data = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(int $vendorId, array $data = [])
    {
        $this->vendorId = $vendorId;
        $this->data = $data;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function markVerified(): void
    {
        $this->status = 'verified';
    }

    public function markRejected(): void
    {
        $this->status = 'rejected';
    }
}
