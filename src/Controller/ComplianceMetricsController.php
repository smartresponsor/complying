<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\ComplianceMetricsRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance metrics controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceMetricsController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceMetricsRegistry $registry)
    {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/metrics', name: 'compliance_metrics', methods: ['GET'])]
    public function __invoke(): Response
    {
        $content = $this->registry->export();

        return new Response($content, 200, ['Content-Type' => 'text/plain; version=0.0.4']);
    }
}
