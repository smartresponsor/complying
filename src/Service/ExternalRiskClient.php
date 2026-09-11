<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ExternalRiskClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        private readonly string $endpoint,
        private readonly float $timeout = 2.5,
    ) {
    }

    /**
     * @param array<string, mixed> $facts
     *
     * @return array<string, mixed>|null
     */
    public function fetchRisk(array $facts): ?array
    {
        try {
            $resp = $this->httpClient->request('POST', $this->endpoint, [
                'json' => $facts,
                'timeout' => $this->timeout,
            ]);
            if (200 !== $resp->getStatusCode()) {
                $this->logger->warning('external risk non-200', ['code' => $resp->getStatusCode()]);

                return null;
            }
            $data = $resp->toArray(false);

            return \is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            $this->logger->error('external risk failed', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
