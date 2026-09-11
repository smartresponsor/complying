<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

final class WebhookSigner
{
    public function __construct(private readonly string $secret)
    {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function sign(array $payload): string
    {
        return hash_hmac('sha256', json_encode($payload, \JSON_UNESCAPED_UNICODE), $this->secret);
    }
}
