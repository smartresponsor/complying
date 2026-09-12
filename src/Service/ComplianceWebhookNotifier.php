<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Coordinates the compliance webhook notifier responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceWebhookNotifier
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $endpoint,
        private readonly ?string $secret = null,
    ) {
    }

    /**
     * Performs the send behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function send(array $payload): void
    {
        $headers = ['Content-Type' => 'application/json'];
        if ($this->secret) {
            $headers['X-Compliance-Signature'] = hash_hmac(
                'sha256',
                json_encode($payload, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR),
                $this->secret,
            );
        }

        $this->httpClient->request('POST', $this->endpoint, [
            'headers' => $headers,
            'json' => $payload,
            'timeout' => 2.0,
        ]);
    }
}
