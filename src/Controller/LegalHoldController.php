<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Controller;

use App\Complying\Service\LegalHoldService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/compliance/legal-hold')]
final class LegalHoldController
{
    public function __construct(private readonly LegalHoldService $service)
    {
    }

    #[Route(path: '', methods: ['POST'])]
    public function set(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $this->service->set($data['object_id'] ?? '', $data['reason'] ?? '', $data['until'] ?? null);

        return new JsonResponse(['ok' => true]);
    }
}
