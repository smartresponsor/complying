<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance reporting service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceReportingService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the daily behavior as part of the owning compliance responsibility.
     *
     * @return array<int, array<string, mixed>>
     */
    public function daily(?\DateTimeImmutable $date = null): array
    {
        $date = $date ?? new \DateTimeImmutable('today');
        $day = $date->format('Y-m-d');

        $sql = <<<SQL
SELECT outcome, COUNT(*) AS cnt
FROM compliance_decision_log
WHERE decided_at::date = :day
GROUP BY outcome
ORDER BY outcome
SQL;
        $rows = $this->connection->fetchAllAssociative($sql, ['day' => $day]);

        $byOutcome = [];
        foreach ($rows as $row) {
            $byOutcome[$row['outcome']] = (int) $row['cnt'];
        }

        $total = array_sum($byOutcome);

        return [
            [
                'date' => $day,
                'total' => $total,
                'permit' => $byOutcome['PERMIT'] ?? 0,
                'deny' => $byOutcome['DENY'] ?? 0,
                'review' => $byOutcome['REVIEW'] ?? 0,
            ],
        ];
    }
}
