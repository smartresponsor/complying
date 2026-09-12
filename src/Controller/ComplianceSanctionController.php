<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\ComplianceSanctionImportServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance sanction controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceSanctionController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceSanctionImportServiceInterface $service)
    {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/sanction/import', name: 'compliance_sanction_import', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true) ?? [];
        $count = $this->service->import($body);

        return new JsonResponse(['imported' => $count]);
    }
}
