<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Message\ComplianceOutboxMessage;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Coordinates the compliance outbox dispatcher responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOutboxDispatcher
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly Connection $connection,
        private readonly MessageBusInterface $bus,
    ) {
    }

    /**
     * Performs the dispatch pending behavior as part of the owning compliance responsibility.
     */
    public function dispatchPending(int $limit = 100): void
    {
        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, type, payload FROM compliance_outbox WHERE dispatched_at IS NULL ORDER BY id ASC LIMIT :lim',
            ['lim' => $limit],
            ['lim' => ParameterType::INTEGER]
        );

        foreach ($rows as $row) {
            $payload = json_decode($row['payload'], true) ?? [];
            $this->bus->dispatch(new ComplianceOutboxMessage($row['type'], $payload));
            $this->connection->update(
                'compliance_outbox',
                ['dispatched_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')],
                ['id' => $row['id']]
            );
        }
    }
}
