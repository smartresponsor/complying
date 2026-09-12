<?php

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

/**
 * Defines the behavioral contract for compliance sanction import service interface collaborators in the compliance component.
 */
interface ComplianceSanctionImportServiceInterface
{
    /**
     * Performs the import behavior as part of the owning compliance responsibility.
     *
     * @param array<int, array{nameEntity: string, source?: string}> $entries
     *
     * @return int imported count
     */
    public function import(array $entries): int;
}
