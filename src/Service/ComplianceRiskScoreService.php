<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceRiskScoreDTO;

/**
 * Coordinates the compliance risk score service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRiskScoreService
{
    /**
     * Performs the calculate behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $facts
     */
    public function calculate(array $facts): ComplianceRiskScoreDTO
    {
        $score = 0;
        $reasons = [];

        if (($facts['is_sanctioned'] ?? false) === true) {
            $score = max($score, 100);
            $reasons[] = 'sanction_match';
        }

        if (isset($facts['country']) && \in_array($facts['country'], ['RU', 'BY', 'IR', 'KP'], true)) {
            $score = max($score, 85);
            $reasons[] = 'high_risk_country';
        }

        if (($facts['amount'] ?? 0) > 10000) {
            $score = max($score, 70);
            $reasons[] = 'high_amount';
        }

        if (($facts['manual_review'] ?? false) === true) {
            $score = max($score, 60);
            $reasons[] = 'manual_review_flag';
        }

        return new ComplianceRiskScoreDTO($score, $reasons);
    }
}
