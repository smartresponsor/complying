<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceSanctionListEntry;
use App\Complying\RepositoryInterface\ComplianceSanctionListEntryRepositoryInterface;
use App\Complying\ServiceInterface\ComplianceSanctionImportServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance sanction import service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceSanctionImportService implements ComplianceSanctionImportServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ComplianceSanctionListEntryRepositoryInterface $repo,
    ) {
    }

    /**
     * Performs the import behavior as part of the owning compliance responsibility.
     *
     * @param array<int, array{nameEntity: string, source?: string}> $entries
     *
     * @return int imported count
     */
    public function import(array $entries): int
    {
        $imported = 0;
        foreach ($entries as $entry) {
            $nameEntity = $entry['nameEntity'];
            if ($this->repo->existsByName($nameEntity)) {
                continue;
            }
            $entity = new ComplianceSanctionListEntry($nameEntity, $entry['source'] ?? null);
            $this->em->persist($entity);
            ++$imported;
        }

        if ($imported > 0) {
            $this->em->flush();
        }

        return $imported;
    }
}
