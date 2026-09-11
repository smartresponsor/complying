<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'fraud_signal')]
class ComplianceFraudSignal
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $vendorId;

    #[ORM\Column(length: 48)]
    private string $type;

    #[ORM\Column(type: 'decimal', precision: 6, scale: 2)]
    private string $score;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $context = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(int $vendorId, string $type, string $score, array $context = [])
    {
        $this->vendorId = $vendorId;
        $this->type = $type;
        $this->score = $score;
        $this->context = $context;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getScore(): string
    {
        return $this->score;
    }
}
