<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Entity\ComplianceCaseQueue;

interface CaseQueueServiceInterface
{
    public function createFromDecision(ComplianceDecisionDTO $decision, ?string $objectId): ComplianceCaseQueue;

    /**
     * @return array<int, ComplianceCaseQueue>
     */
    public function listOpen(): array;

    public function close(int $id, string $actor): void;
}
