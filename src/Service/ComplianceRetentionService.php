<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\ORM\EntityManagerInterface;

final class ComplianceRetentionService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

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
