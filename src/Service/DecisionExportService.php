<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class DecisionExportService
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return \Generator<string>
     */
    public function exportDecisions(?int $fromId = null, ?\DateTimeImmutable $fromDate = null): \Generator
    {
        $sql = 'SELECT id, object_id, event_name, outcome, tenant_id, policy_id, policy_version, facts, decided_at FROM compliance_decision_log';
        $where = [];
        $params = [];

        if (null !== $fromId) {
            $where[] = 'id > :fromId';
            $params['fromId'] = $fromId;
        }
        if (null !== $fromDate) {
            $where[] = 'decided_at >= :fromDate';
            $params['fromDate'] = $fromDate->format('Y-m-d H:i:s');
        }
        if ([] !== $where) {
            $sql .= ' WHERE '.implode(' AND ', $where);
        }
        $sql .= ' ORDER BY id ASC';

        $stmt = $this->connection->executeQuery($sql, $params);

        while ($row = $stmt->fetchAssociative()) {
            $row['facts'] = json_decode($row['facts'] ?? '[]', true);
            yield json_encode($row, \JSON_UNESCAPED_UNICODE)."\n";
        }
    }
}
