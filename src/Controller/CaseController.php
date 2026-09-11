<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\CaseQueueServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CaseController
{
    public function __construct(private readonly CaseQueueServiceInterface $service)
    {
    }

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

    #[Route(path: '/compliance/cases/{id}/close', name: 'compliance_case_close', methods: ['POST'])]
    public function close(int $id, Request $request): JsonResponse
    {
        $actor = $request->headers->get('X-User', 'system');
        $this->service->close($id, $actor);

        return new JsonResponse(['closed' => true]);
    }
}
