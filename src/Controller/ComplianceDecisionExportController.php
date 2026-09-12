<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\ComplianceDecisionExportService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance decision export controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceDecisionExportController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceDecisionExportService $service)
    {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/export/decisions.ndjson', name: 'compliance_export_decisions', methods: ['GET'])]
    public function __invoke(Request $request): StreamedResponse
    {
        $fromId = $request->query->getInt('from_id', 0);
        $fromDate = $request->query->get('from_date');

        $dateObj = null;
        if ($fromDate) {
            $dateObj = new \DateTimeImmutable($fromDate);
        }

        $resp = new StreamedResponse(function () use ($fromId, $dateObj): void {
            foreach ($this->service->exportDecisions($fromId > 0 ? $fromId : null, $dateObj) as $line) {
                echo $line;
                flush();
            }
        });

        $resp->headers->set('Content-Type', 'application/x-ndjson');
        $resp->headers->set('Content-Disposition', 'attachment; filename="compliance-decisions.ndjson"');

        return $resp;
    }
}
