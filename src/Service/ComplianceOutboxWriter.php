<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class ComplianceOutboxWriter
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function write(string $type, array $payload): void
    {
        $this->connection->insert('compliance_outbox', [
            'type' => $type,
            'payload' => json_encode($payload, \JSON_UNESCAPED_UNICODE),
            'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'dispatched_at' => null,
        ]);
    }
}
