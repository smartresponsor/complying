<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance fraud signal concept and protects its compliance workflow invariants.
 */
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

    /** @var array<string, mixed>|null */
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $context = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<string, mixed> $context */
    public function __construct(int $vendorId, string $type, string $score, array $context = [])
    {
        $this->vendorId = $vendorId;
        $this->type = $type;
        $this->score = $score;
        $this->context = $context;
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
     * Returns the get type value exposed by this compliance responsibility.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the get score value exposed by this compliance responsibility.
     */
    public function getScore(): string
    {
        return $this->score;
    }

    /**
     * Returns the get context value exposed by this compliance responsibility.
     *
     * @return array<string, mixed>|null */
    public function getContext(): ?array
    {
        return $this->context;
    }

    /**
     * Returns the get created at value exposed by this compliance responsibility.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
