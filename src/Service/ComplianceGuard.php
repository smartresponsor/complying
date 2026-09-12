<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Exception\ComplianceDeniedException;
use App\Complying\Exception\ComplianceUnavailableException;
use App\Complying\ServiceInterface\CompliancePolicyEvaluationServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Coordinates the compliance guard responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceGuard
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyEvaluationServiceInterface $service,
        private readonly ComplianceDeferredDecisionService $deferred,
        private readonly LoggerInterface $logger,
        private readonly bool $fallbackToDeferred = true,
    ) {
    }

    /**
     * Performs the guard behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     *
     * @throws ComplianceDeniedException
     * @throws ComplianceUnavailableException
     */
    public function guard(string $eventName, array $payload): ComplianceDecisionDTO
    {
        try {
            $decision = $this->service->decide($eventName, $payload);
        } catch (\Throwable $e) {
            if ($this->fallbackToDeferred) {
                $this->deferred->defer($eventName, $payload);
                $this->logger->error('Compliance unreachable, decision deferred', ['event' => $eventName, 'error' => $e->getMessage()]);
                throw new ComplianceUnavailableException('Compliance decision deferred');
            }

            throw new ComplianceUnavailableException('Compliance service not available: '.$e->getMessage());
        }

        if ('DENY' === $decision->outcome) {
            throw new ComplianceDeniedException('Compliance denied: '.$eventName);
        }

        if ('REVIEW' === $decision->outcome) {
            // just log, case will be created by writer
            $this->logger->warning('Compliance review required', ['event' => $eventName]);
        }

        return $decision;
    }
}
