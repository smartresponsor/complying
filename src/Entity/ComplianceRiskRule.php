<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    public function __construct(string $nameEntity, string $dsl, string $score)
    {
        $this->nameEntity = $nameEntity;
        $this->dsl = $dsl;
        $this->score = $score;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getDsl(): string
    {
        return $this->dsl;
    }

    public function getScore(): float
    {
        return (float) $this->score;
    }

    public function getName(): string
    {
        return $this->nameEntity;
    }
}
