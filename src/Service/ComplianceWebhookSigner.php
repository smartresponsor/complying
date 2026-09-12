<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

/**
 * Coordinates the compliance webhook signer responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceWebhookSigner
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly string $secret)
    {
    }

    /**
     * Performs the sign behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function sign(array $payload): string
    {
        return hash_hmac(
            'sha256',
            json_encode($payload, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR),
            $this->secret,
        );
    }
}
