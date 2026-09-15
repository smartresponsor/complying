<?php

declare(strict_types=1);

namespace App\Complying\Service\Payment;

use App\Complying\Service\ComplianceRealtimeGuard;

/**
 * Coordinates the compliance payment guard responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePaymentGuard
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceRealtimeGuard $guard)
    {
    }

    /**
     * Example hook for payment authorization.
     *
     * @param array<string, mixed> $extra
     *
     * @return array{decision: string, reasons: list<string>}
     */
    public function authorize(int $vendorId, int $amountMinor, array $extra = []): array
    {
        $facts = array_merge($extra, ['vendor_id' => $vendorId, 'amount_minor' => $amountMinor]);

        return $this->guard->decide($facts);
    }
}
