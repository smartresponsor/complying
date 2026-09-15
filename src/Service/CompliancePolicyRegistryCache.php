<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance policy registry cache responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePolicyRegistryCache
{
    /** @var array<string, array<string,mixed>> */
    private array $cache = [];

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Returns the get value exposed by this compliance responsibility.
     *
     * @return array<string, mixed>|null */
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
