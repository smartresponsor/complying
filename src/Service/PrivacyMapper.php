<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

final class PrivacyMapper
{
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
