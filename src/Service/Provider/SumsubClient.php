<?php

declare(strict_types=1);

namespace App\Complying\Service\Provider;

final class SumsubClient
{
    public function verify(array $payload): array
    {
        return ['status' => 'verified', 'provider' => 'sumsub', 'id' => $payload['id'] ?? null];
    }
}
