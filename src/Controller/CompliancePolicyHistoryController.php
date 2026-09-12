<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\CompliancePolicyHistoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance policy history controller HTTP boundary and delegates compliance behavior to application services.
 */
#[Route(path: '/compliance/policy')]
final class CompliancePolicyHistoryController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly CompliancePolicyHistoryService $service)
    {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/history/{id}', methods: ['GET'])]
    public function __invoke(string $id): JsonResponse
    {
        return new JsonResponse($this->service->history($id));
    }
}
