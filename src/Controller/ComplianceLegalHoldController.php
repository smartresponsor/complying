<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Controller;

use App\Complying\Service\ComplianceLegalHoldService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance legal hold controller HTTP boundary and delegates compliance behavior to application services.
 */
#[Route(path: '/compliance/legal/hold')]
final class ComplianceLegalHoldController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceLegalHoldService $service)
    {
    }

    /**
     * Updates the set value while preserving the owning compliance invariant.
     */
    #[Route(path: '', methods: ['POST'])]
    public function set(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $this->service->set($data['object_id'] ?? '', $data['reason'] ?? '', $data['until'] ?? null);

        return new JsonResponse(['ok' => true]);
    }
}
