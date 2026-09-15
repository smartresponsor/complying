<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\CompliancePolicyRegistryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance policy registry controller HTTP boundary and delegates compliance behavior to application services.
 */
final class CompliancePolicyRegistryController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly CompliancePolicyRegistryService $service)
    {
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/policies', name: 'compliance_policies', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse($this->service->list());
    }

    /**
     * Performs the refresh behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/policies/refresh', name: 'compliance_policies_refresh', methods: ['POST'])]
    public function refresh(): JsonResponse
    {
        $count = $this->service->refresh();

        return new JsonResponse(['refreshed' => $count]);
    }
}
