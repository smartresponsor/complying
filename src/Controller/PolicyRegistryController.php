<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\PolicyRegistryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PolicyRegistryController
{
    public function __construct(private readonly PolicyRegistryService $service)
    {
    }

    #[Route(path: '/compliance/policies', name: 'compliance_policies', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse($this->service->list());
    }

    #[Route(path: '/compliance/policies/refresh', name: 'compliance_policies_refresh', methods: ['POST'])]
    public function refresh(): JsonResponse
    {
        $count = $this->service->refresh();

        return new JsonResponse(['refreshed' => $count]);
    }
}
