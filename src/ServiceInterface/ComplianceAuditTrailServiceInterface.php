<?php

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

/**
 * Defines the behavioral contract for compliance audit trail service interface collaborators in the compliance component.
 */
interface ComplianceAuditTrailServiceInterface
{
    /**
     * Performs the add behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function add(string $action, array $payload = []): void;
}
