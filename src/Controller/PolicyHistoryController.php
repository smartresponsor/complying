<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\PolicyHistoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/compliance/policy')]
final class PolicyHistoryController
{
    public function __construct(private readonly PolicyHistoryService $service)
    {
    }

    #[Route(path: '/{id}/history', methods: ['GET'])]
    public function __invoke(string $id): JsonResponse
    {
        return new JsonResponse($this->service->history($id));
    }
}
