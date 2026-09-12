<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\ExportService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExportController
{
    public function __construct(private readonly ExportService $service)
    {
    }

    #[Route(path: '/compliance/export', name: 'compliance_export', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $format = $request->query->get('format', 'csv');
        $from = $request->query->get('from');
        $to = $request->query->get('to');
        $outcome = $request->query->get('outcome');

        $fromDt = $from ? new \DateTimeImmutable($from) : null;
        $toDt = $to ? new \DateTimeImmutable($to) : null;

        $rows = $this->service->fetchDecisions($fromDt, $toDt, $outcome);

        if ('ndjson' === $format) {
            $body = $this->service->toNdjson($rows);

            return new Response($body, 200, ['Content-Type' => 'application/x-ndjson']);
        }

        $body = $this->service->toCsv($rows);

        return new Response($body, 200, ['Content-Type' => 'text/csv']);
    }
}
