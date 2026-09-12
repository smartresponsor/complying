<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance risk rule concept and protects its compliance workflow invariants.
 */
#[ORM\Entity]
#[ORM\Table(name: 'risk_rule')]
class ComplianceRiskRule
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(length: 64)]
    private string $nameEntity;

    #[ORM\Column(type: 'text')]
    private string $dsl;

    #[ORM\Column(type: 'decimal', precision: 6, scale: 2)]
    private string $score;

    #[ORM\Column(type: 'boolean')]
    private bool $active = true;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(string $nameEntity, string $dsl, string $score)
    {
        $this->nameEntity = $nameEntity;
        $this->dsl = $dsl;
        $this->score = $score;
    }

    /**
     * Reports whether the is active condition currently holds for this compliance responsibility.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Returns the get dsl value exposed by this compliance responsibility.
     */
    public function getDsl(): string
    {
        return $this->dsl;
    }

    /**
     * Returns the get score value exposed by this compliance responsibility.
     */
    public function getScore(): float
    {
        return (float) $this->score;
    }

    /**
     * Returns the get name value exposed by this compliance responsibility.
     */
    public function getName(): string
    {
        return $this->nameEntity;
    }
}
