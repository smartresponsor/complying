<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;

final class ConsentChecker
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function hasConsent(string $userId, string $purpose): bool
    {
        $row = $this->connection->fetchAssociative(
            'SELECT granted_at, withdrawn_at FROM compliance_consent WHERE user_id = :u AND purpose = :p ORDER BY granted_at DESC LIMIT 1',
            ['u' => $userId, 'p' => $purpose]
        );
        if (!$row) {
            return false;
        }
        if (!empty($row['withdrawn_at'])) {
            return false;
        }

        return true;
    }
}
