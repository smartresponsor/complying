<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\DTO;

final class RiskScoreDTO
{
    /**
     * @param array<int, string> $reasons
     */
    public function __construct(
        public readonly int $score,
        public readonly array $reasons = [],
    ) {
    }

    /**
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
