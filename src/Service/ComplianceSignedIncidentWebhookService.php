<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

/**
 * Coordinates the compliance signed incident webhook service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceSignedIncidentWebhookService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceIncidentWebhookService $inner,
        private readonly ComplianceWebhookSigner $signer,
    ) {
    }

    /**
     * Performs the send behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $incident */
    public function send(array $incident): void
    {
        $signature = $this->signer->sign($incident);
        $incident['_headers'] = [
            'X-Compliance-Sign' => $signature,
        ];

        $this->inner->send($incident);
    }
}
