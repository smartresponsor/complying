<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance decision log bulk writer responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDecisionLogBulkWriter
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the write behavior as part of the owning compliance responsibility.
     *
     * @param array<int, array{event:string,outcome:string,facts:string}> $rows
     */
    public function write(array $rows): void
    {
        if ([] === $rows) {
            return;
        }
        $valuesSql = [];
        $params = [];
        foreach ($rows as $row) {
            $valuesSql[] = '(?, ?, ?, NOW())';
            $params[] = $row['event'];
            $params[] = $row['outcome'];
            $params[] = $row['facts'];
        }
        $sql = 'INSERT INTO compliance_decision_log (event, outcome, facts, decided_at) VALUES '.implode(', ', $valuesSql);
        $this->connection->executeStatement($sql, $params);
    }
}
