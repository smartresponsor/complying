<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\ComplianceCaseQueueServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance case ui controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceCaseUiController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceCaseQueueServiceInterface $service)
    {
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     *
     * @return array<string, mixed>
     */
    #[Route(path: '/admin/compliance/cases', name: 'admin_compliance_cases', methods: ['GET'])]
    public function list(): array
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

    /**
     * Performs the close behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/admin/compliance/cases/close/{id}', name: 'admin_compliance_case_close', methods: ['POST'])]
    public function close(int $id, Request $request): Response
    {
        $actor = (string) $request->headers->get('X-User', 'admin');
        $this->service->close($id, $actor);

        return new RedirectResponse('/admin/compliance/cases');
    }
}
