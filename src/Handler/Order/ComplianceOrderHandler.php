<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Handler\Order;

use App\Complying\Service\ComplianceDecisionLogWriter;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;

/**
 * Coordinates the compliance order handler responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOrderHandler
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $service,
        private readonly ComplianceDecisionLogWriter $logWriter,
    ) {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $order
     */
    public function __invoke(array $order): void
    {
        $decision = $this->service->decide('order.created', $order);

        $this->logWriter->write($decision, $order['id'] ?? null, 'order.created');

        if ('DENY' === $decision->outcome) {
            throw new \RuntimeException('Order blocked by compliance');
        }

        if ('REVIEW' === $decision->outcome) {
            $this->logWriter->createCase($decision, $order['id'] ?? null);
        }
    }
}
