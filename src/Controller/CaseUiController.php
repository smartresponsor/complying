<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\CaseQueueServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CaseUiController
{
    public function __construct(private readonly CaseQueueServiceInterface $service)
    {
    }

    #[Route(path: '/admin/compliance/cases', name: 'admin_compliance_cases', methods: ['GET'])]
    /**
     * @return Response|array<string, mixed>
     */
    public function list(): Response|array
    {
        $cases = $this->service->listOpen();

        return [
            '_view' => [
                'surface' => 'compliance',
                'operation' => 'case-list',
                'component' => 'Complying',
                'intent' => 'admin',
            ],
            'data' => [
                'cases' => $cases,
            ],
            'meta' => [
                'source_controller' => self::class,
            ],
        ];
    }

    #[Route(path: '/admin/compliance/cases/{id}/close', name: 'admin_compliance_case_close', methods: ['POST'])]
    public function close(int $id, Request $request): Response
    {
        $actor = $request->headers->get('X-User', 'admin');
        $this->service->close($id, $actor);

        return new RedirectResponse('/admin/compliance/cases');
    }
}
