<?php

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

interface ComplianceAuditTrailServiceInterface
{
    /**
     * @param array<string, mixed> $payload
     */
    public function add(string $action, array $payload = []): void;
}
