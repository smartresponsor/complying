<?php

declare(strict_types=1);

namespace App\Complying\Service\Provider;

final class ComplyAdvantageClient
{
    public function screen(array $payload): array
    {
        return ['result' => 'clear', 'provider' => 'comply_advantage', 'query' => $payload['nameEntity'] ?? null];
    }
}
