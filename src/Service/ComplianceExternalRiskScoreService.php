<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

/**
 * Coordinates the compliance external risk score service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceExternalRiskScoreService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceRiskScoreService $inner,
        private readonly ComplianceExternalRiskClient $client,
    ) {
    }

    /**
     * Performs the score behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $facts
     *
     * @return array<string, mixed>
     */
    public function score(array $facts): array
    {
        $res = $this->inner->calculate($facts)->toArray();

        if (($facts['needs_ml'] ?? false) === true) {
            $ext = $this->client->fetchRisk($facts);
            if (\is_array($ext) && isset($ext['score'])) {
                // берём максимум, чтобы не занижать
                $res['score'] = max((int) $res['score'], (int) $ext['score']);
                if (isset($ext['reason'])) {
                    $res['reason_ext'] = $ext['reason'];
                }
            }
        }

        return $res;
    }
}
