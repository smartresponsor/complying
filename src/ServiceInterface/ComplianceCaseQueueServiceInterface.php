<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Entity\ComplianceCaseQueue;

/**
 * Defines the behavioral contract for compliance case queue service interface collaborators in the compliance component.
 */
interface ComplianceCaseQueueServiceInterface
{
    /**
     * Performs the create from decision behavior as part of the owning compliance responsibility.
     */
    public function createFromDecision(ComplianceDecisionDTO $decision, ?string $objectId): ComplianceCaseQueue;

    /**
     * Performs the list open behavior as part of the owning compliance responsibility.
     *
     * @return array<int, ComplianceCaseQueue>
     */
    public function listOpen(): array;

    /**
     * Performs the close behavior as part of the owning compliance responsibility.
     */
    public function close(int $id, string $actor): void;
}
