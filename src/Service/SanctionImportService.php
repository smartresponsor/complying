<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceSanctionListEntry;
use App\Complying\RepositoryInterface\SanctionListEntryRepositoryInterface;
use App\Complying\ServiceInterface\SanctionImportServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class SanctionImportService implements SanctionImportServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly SanctionListEntryRepositoryInterface $repo,
    ) {
    }

    /**
     * @param array<int, array{name: string, source?: string}> $entries
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
