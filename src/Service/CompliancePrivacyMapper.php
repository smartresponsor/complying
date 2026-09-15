<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

/**
 * Coordinates the compliance privacy mapper responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePrivacyMapper
{
    /**
     * Performs the map behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $facts
     *
     * @return array<string, mixed>
     */
    public function map(array $facts): array
    {
        $facts['gdpr_basis'] = $facts['gdpr_basis'] ?? 'LEGITIMATE_INTEREST';
        $facts['ccpa_category'] = $facts['ccpa_category'] ?? 'other';

        if (($facts['country'] ?? null) === 'EU') {
            $facts['gdpr_basis'] = 'GDPR_ART_6_1_F';
        }

        return $facts;
    }
}
