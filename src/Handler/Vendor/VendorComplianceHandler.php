<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Handler\Vendor;

use App\Complying\Service\ComplianceDecisionLogWriter;
use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;

final class VendorComplianceHandler
{
    public function __construct(
        private readonly CompliancePolicyServiceInterface $service,
        private readonly ComplianceDecisionLogWriter $logWriter,
    ) {
    }

    /**
     * @param array<string, mixed> $vendor
     */
    public function __invoke(array $vendor): void
    {
        $decision = $this->service->decide('vendor.created', $vendor);

        $this->logWriter->write($decision, $vendor['id'] ?? null, 'vendor.created');

        if ('DENY' === $decision->outcome) {
            throw new \RuntimeException('Vendor blocked by compliance');
        }

        if ('REVIEW' === $decision->outcome) {
            $this->logWriter->createCase($decision, $vendor['id'] ?? null);
        }
    }
}
