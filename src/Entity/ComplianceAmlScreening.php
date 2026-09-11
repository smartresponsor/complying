<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $hits = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $screenedAt;

    public function __construct(int $vendorId, string $result = 'clear', array $hits = [])
    {
        $this->vendorId = $vendorId;
        $this->result = $result;
        $this->hits = $hits;
        $this->screenedAt = new \DateTimeImmutable();
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function getResult(): string
    {
        return $this->result;
    }
}
