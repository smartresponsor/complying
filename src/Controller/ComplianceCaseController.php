<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\ComplianceCaseQueueServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance case controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceCaseController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceCaseQueueServiceInterface $service)
    {
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/cases', name: 'compliance_cases', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $cases = $this->service->listOpen();
        $data = [];
        foreach ($cases as $case) {
            $data[] = [
                'id' => $case->getId(),
                'status' => $case->getStatus(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Performs the close behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/cases/close/{id}', name: 'compliance_case_close', methods: ['POST'])]
    public function close(int $id, Request $request): JsonResponse
    {
        $actor = (string) $request->headers->get('X-User', 'system');
        $this->service->close($id, $actor);

        return new JsonResponse(['closed' => true]);
    }
}
