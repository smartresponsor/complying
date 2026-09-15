<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance policy history service responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePolicyHistoryService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the store behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $body */
    public function store(string $policyId, string $version, array $body): void
    {
        $this->connection->insert('compliance_policy_history', [
            'policy_id' => $policyId,
            'policy_version' => $version,
            'body' => json_encode($body, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR),
            'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Performs the history behavior as part of the owning compliance responsibility.
     *
     * @return list<array<string, mixed>> */
    public function history(string $policyId): array
    {
        return $this->connection->fetchAllAssociative(
            'SELECT policy_version, body, created_at FROM compliance_policy_history WHERE policy_id = :id ORDER BY created_at DESC',
            ['id' => $policyId]
        );
    }
}
