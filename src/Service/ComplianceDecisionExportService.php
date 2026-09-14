<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance decision export service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDecisionExportService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the export decisions behavior as part of the owning compliance responsibility.
     *
     * @return \Generator<string>
     */
    public function exportDecisions(?int $fromId = null, ?\DateTimeImmutable $fromDate = null): \Generator
    {
        $sql = 'SELECT id, target_id AS object_id, event_name, outcome, tenant_id, policy_id, policy_version, facts, decided_at FROM compliance_decision_log';
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
