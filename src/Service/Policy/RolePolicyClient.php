<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service\Policy;

use App\Complying\DTO\PolicyDecision;
use App\Complying\DTO\PolicyFactSet;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class RolePolicyClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $endpoint,
    ) {
    }

    public function decide(PolicyFactSet $factSet): PolicyDecision
    {
        $response = $this->httpClient->request('POST', $this->endpoint, [
            'json' => $factSet->toArray(),
            'timeout' => 2.5,
        ]);

        $data = $response->toArray(false);

        return PolicyDecision::fromArray($data);
    }
}
