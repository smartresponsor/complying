<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\SanctionImportServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class SanctionController
{
    public function __construct(private readonly SanctionImportServiceInterface $service)
    {
    }

    #[Route(path: '/compliance/sanction/import', name: 'compliance_sanction_import', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true) ?? [];
        $count = $this->service->import($body);

        return new JsonResponse(['imported' => $count]);
    }
}
