<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Provider;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance policy expression provider responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePolicyExpressionProvider
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the all behavior as part of the owning compliance responsibility.
     *
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

    /**
     * Returns the get value exposed by this compliance responsibility.
     */
    public function get(string $policyId): ?string
    {
        $row = $this->connection->fetchAssociative('SELECT description FROM compliance_policy_registry WHERE policy_id = :id AND source = :src', [
            'id' => $policyId,
            'src' => 'expression',
        ]);

        return $row ? (string) $row['description'] : null;
    }
}
