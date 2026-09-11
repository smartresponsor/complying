<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Handler\Billing;

use App\Complying\Service\ComplianceDecisionLogWriter;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class BillingComplianceHandler
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $service,
        private readonly ComplianceDecisionLogWriter $logWriter,
    ) {
    }

    /**
     * @param array<string, mixed> $payment
     */
    public function __invoke(array $payment): void
    {
        $decision = $this->service->decide('billing.payment.attempted', $payment);

        $this->logWriter->write($decision, $payment['id'] ?? null, 'billing.payment.attempted');

        if ('DENY' === $decision->outcome) {
            throw new \RuntimeException('PaymentEntity blocked by compliance');
        }

        if ('REVIEW' === $decision->outcome) {
            $this->logWriter->createCase($decision, $payment['id'] ?? null);
        }
    }
}
