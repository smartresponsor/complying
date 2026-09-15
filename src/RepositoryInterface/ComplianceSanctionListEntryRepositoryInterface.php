<?php

declare(strict_types=1);

namespace App\Complying\RepositoryInterface;

/**
 * Coordinates the compliance sanction list entry repository interface responsibility within the Complying component and its explicit boundaries.
 */
interface ComplianceSanctionListEntryRepositoryInterface
{
    /**
     * Performs the exists by name behavior as part of the owning compliance responsibility.
     */
    public function existsByName(string $nameEntity): bool;
}
