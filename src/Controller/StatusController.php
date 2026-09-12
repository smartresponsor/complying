<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StatusController
{
    public function __construct(private readonly Connection $connection)
    {
    }

    #[Route(path: '/compliance/status', name: 'compliance_status', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $ok = true;
        $err = null;

        try {
            $this->connection->executeQuery('SELECT 1');
        } catch (\Throwable $e) {
            $ok = false;
            $err = $e->getMessage();
        }

        return new JsonResponse([
            'status' => $ok ? 'ok' : 'error',
            'error' => $err,
            'time' => (new \DateTimeImmutable('now'))->format(\DATE_ATOM),
        ], $ok ? 200 : 500);
    }
}
