<?php

declare(strict_types=1);

namespace App\Complying\Service\Provider;

/**
 * Coordinates the compliance comply advantage client responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceComplyAdvantageClient
{
    /**
     * Performs the screen behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     *
     * @return array{result: string, provider: string, query: mixed}
     */
    public function screen(array $payload): array
    {
        return ['result' => 'clear', 'provider' => 'comply_advantage', 'query' => $payload['nameEntity'] ?? null];
    }
}
