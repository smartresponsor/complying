<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance admin audit controller HTTP boundary and delegates compliance behavior to application services.
 */
#[Route(path: '/compliance/admin/audit')]
final class ComplianceAdminAuditController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $sql = 'SELECT id, action, payload, created_at FROM compliance_audit_log WHERE 1=1';
        $params = [];

        $actor = $request->query->get('actor');
        if ($actor) {
            $sql .= ' AND payload LIKE :actor';
            $params['actor'] = '%\"actor\":\"'.$actor.'\"%';
        }

        $action = $request->query->get('action');
        if ($action) {
            $sql .= ' AND action = :act';
            $params['act'] = $action;
        }

        $sql .= ' ORDER BY created_at DESC LIMIT 500';

        $rows = $this->connection->fetchAllAssociative($sql, $params);

        return new JsonResponse($rows);
    }
}
