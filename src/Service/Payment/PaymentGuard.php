<?php

declare(strict_types=1);

namespace App\Complying\Service\Payment;

use App\Complying\Service\RealtimeGuard;

final class PaymentGuard
{
    public function __construct(private readonly RealtimeGuard $guard)
    {
    }

    /**
     * Example hook for payment authorization.
     *
     * @return array{decision:string, reasons:array}
     */
    public function authorize(int $vendorId, int $amountMinor, array $extra = []): array
    {
        $facts = array_merge($extra, ['vendor_id' => $vendorId, 'amount_minor' => $amountMinor]);

        return $this->guard->decide($facts);
    }
}
