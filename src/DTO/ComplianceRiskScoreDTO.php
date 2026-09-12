<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\DTO;

/**
 * Carries immutable compliance risk score d t o data across an explicit compliance application boundary.
 */
final class ComplianceRiskScoreDTO
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<int, string> $reasons
     */
    public function __construct(
        public readonly int $score,
        public readonly array $reasons = [],
    ) {
    }

    /**
     * Performs the to array behavior as part of the owning compliance responsibility.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'score' => $this->score,
            'reasons' => $this->reasons,
        ];
    }
}
