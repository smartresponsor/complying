<?php

declare(strict_types=1);

namespace App\Complying\Service\Provider;

final class OnfidoClient
{
    public function verify(array $payload): array
    {
        return ['status' => 'review', 'provider' => 'onfido', 'id' => $payload['id'] ?? null];
    }
}
