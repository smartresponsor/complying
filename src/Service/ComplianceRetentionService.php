<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance retention service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRetentionService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the archive older than behavior as part of the owning compliance responsibility.
     */
    public function archiveOlderThan(int $days): int
    {
        $date = (new \DateTimeImmutable('now'))->modify('-'.$days.' days');

        $conn = $this->em->getConnection();
        $rows = $conn->fetchAllAssociative(
            'SELECT * FROM compliance_decision_log WHERE decided_at < :dt ORDER BY id LIMIT 1000',
            ['dt' => $date->format('Y-m-d H:i:s')]
        );

        $count = 0;
        foreach ($rows as $row) {
            $archive = new \App\Complying\Entity\ComplianceDecisionLogArchive($row);
            $this->em->persist($archive);
            $conn->executeStatement('DELETE FROM compliance_decision_log WHERE id = :id', ['id' => $row['id']]);
            ++$count;
        }

        if ($count > 0) {
            $this->em->flush();
        }

        return $count;
    }
}
