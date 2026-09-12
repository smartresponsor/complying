<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Coordinates the compliance external risk client responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceExternalRiskClient
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        private readonly string $endpoint,
        private readonly float $timeout = 2.5,
    ) {
    }

    /**
     * Performs the fetch risk behavior as part of the owning compliance responsibility.
     *
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

            return $resp->toArray(false);
        } catch (\Throwable $e) {
            $this->logger->error('external risk failed', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
