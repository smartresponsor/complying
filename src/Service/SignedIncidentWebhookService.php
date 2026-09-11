<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

final class SignedIncidentWebhookService
{
    public function __construct(
        private readonly IncidentWebhookService $inner,
        private readonly WebhookSigner $signer,
    ) {
    }

    public function send(array $incident): void
    {
        $signature = $this->signer->sign($incident);
        $incident['_headers'] = [
            'X-Compliance-Sign' => $signature,
        ];

        $this->inner->send($incident);
    }
}
