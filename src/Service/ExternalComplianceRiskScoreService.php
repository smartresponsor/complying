<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

final class ExternalComplianceRiskScoreService
{
    public function __construct(
        private readonly RiskScoreService $inner,
        private readonly ExternalRiskClient $client,
    ) {
    }

    /**
     * @param array<string, mixed> $facts
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
