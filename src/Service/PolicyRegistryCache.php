<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class PolicyRegistryCache
{
    /** @var array<string, array<string,mixed>> */
    private array $cache = [];

    public function __construct(private readonly Connection $connection)
    {
    }

    public function get(string $policyId): ?array
    {
        if (isset($this->cache[$policyId])) {
            return $this->cache[$policyId];
        }
        $row = $this->connection->fetchAssociative('SELECT * FROM compliance_policy_registry WHERE policy_id = :id', ['id' => $policyId]);
        if ($row) {
            $this->cache[$policyId] = $row;
        }

        return $row ?: null;
    }
}
