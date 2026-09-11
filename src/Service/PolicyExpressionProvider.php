<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class PolicyExpressionProvider
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return array<string, string> policy_id => expression
     */
    public function all(): array
    {
        $rows = $this->connection->fetchAllAssociative('SELECT policy_id, description FROM compliance_policy_registry WHERE source = :src', [
            'src' => 'expression',
        ]);

        $out = [];
        foreach ($rows as $row) {
            if (!empty($row['description'])) {
                $out[$row['policy_id']] = (string) $row['description'];
            }
        }

        return $out;
    }

    public function get(string $policyId): ?string
    {
        $row = $this->connection->fetchAssociative('SELECT description FROM compliance_policy_registry WHERE policy_id = :id AND source = :src', [
            'id' => $policyId,
            'src' => 'expression',
        ]);

        return $row ? (string) $row['description'] : null;
    }
}
