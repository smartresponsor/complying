<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service\Mapping;

/**
 * Coordinates the compliance fact mapping service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceFactMappingService
{
    /**
     * Performs the map behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     *
     * @return array<string, mixed>
     */
    public function map(string $eventName, array $payload): array
    {
        if ('order.created' === $eventName) {
            return [
                'amount' => $payload['total'] ?? 0,
                'currency' => $payload['currency'] ?? 'USD',
                'customer_id' => $payload['customer_id'] ?? null,
                'vendor_id' => $payload['vendor_id'] ?? null,
                'country' => $payload['country'] ?? null,
                'ip' => $payload['ip'] ?? null,
            ];
        }

        if ('billing.payment.attempted' === $eventName) {
            return [
                'amount' => $payload['amount'] ?? 0,
                'currency' => $payload['currency'] ?? 'USD',
                'payment_method' => $payload['payment_method'] ?? null,
                'customer_id' => $payload['customer_id'] ?? null,
            ];
        }

        if ('vendor.created' === $eventName || 'vendor.updated' === $eventName) {
            return [
                'vendor_id' => $payload['id'] ?? null,
                'vendor_country' => $payload['country'] ?? null,
                'vendor_tax_id' => $payload['tax_id'] ?? null,
                'vendor_type' => $payload['type'] ?? null,
                'vendor_owner' => $payload['owner_id'] ?? null,
            ];
        }

        return $payload;
    }
}
