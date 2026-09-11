<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class DecisionLogBulkWriter
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
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
