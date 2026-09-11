<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class PolicyHistoryService
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function store(string $policyId, string $version, array $body): void
    {
        $this->connection->insert('compliance_policy_history', [
            'policy_id' => $policyId,
            'policy_version' => $version,
            'body' => json_encode($body, \JSON_UNESCAPED_UNICODE),
            'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ]);
    }

    public function history(string $policyId): array
    {
        return $this->connection->fetchAllAssociative(
            'SELECT policy_version, body, created_at FROM compliance_policy_history WHERE policy_id = :id ORDER BY created_at DESC',
            ['id' => $policyId]
        );
    }
}
