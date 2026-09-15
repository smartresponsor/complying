<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

/**
 * Coordinates the compliance outbox writer responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOutboxWriter
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the write behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload */
    public function write(string $type, array $payload): void
    {
        $this->connection->insert('compliance_outbox', [
            'type' => $type,
            'payload' => json_encode($payload, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR),
            'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'dispatched_at' => null,
        ]);
    }
}
