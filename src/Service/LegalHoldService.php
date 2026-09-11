<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class LegalHoldService
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function set(string $objectId, string $reason, ?string $until): void
    {
        $this->connection->insert('compliance_legal_hold', [
            'object_id' => $objectId,
            'reason' => $reason,
            'until' => $until,
        ]);
    }

    public function isOnHold(string $objectId): bool
    {
        $row = $this->connection->fetchAssociative(
            'SELECT 1 FROM compliance_legal_hold WHERE object_id = :id AND (until IS NULL OR until > NOW()) LIMIT 1',
            ['id' => $objectId]
        );

        return (bool) $row;
    }
}
