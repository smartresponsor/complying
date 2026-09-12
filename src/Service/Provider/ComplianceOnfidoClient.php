<?php

declare(strict_types=1);

namespace App\Complying\Service\Provider;

/**
 * Coordinates the compliance onfido client responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOnfidoClient
{
    /**
     * Performs the verify behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     *
     * @return array{status: string, provider: string, id: mixed}
     */
    public function verify(array $payload): array
    {
        return ['status' => 'review', 'provider' => 'onfido', 'id' => $payload['id'] ?? null];
    }
}
