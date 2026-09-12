<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\MetricsRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MetricsController
{
    public function __construct(private readonly MetricsRegistry $registry)
    {
    }

    #[Route(path: '/compliance/metrics', name: 'compliance_metrics', methods: ['GET'])]
    public function __invoke(): Response
    {
        $content = $this->registry->export();

        return new Response($content, 200, ['Content-Type' => 'text/plain; version=0.0.4']);
    }
}
