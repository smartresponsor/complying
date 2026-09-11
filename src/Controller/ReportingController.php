<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\ReportingService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ReportingController
{
    public function __construct(private readonly ReportingService $service)
    {
    }

    #[Route(path: '/compliance/report/daily', name: 'compliance_report_daily', methods: ['GET'])]
    public function daily(Request $request): Response
    {
        $date = $request->query->get('date');
        $dateObj = $date ? new \DateTimeImmutable($date) : null;
        $rows = $this->service->daily($dateObj);

        if ($request->query->getBoolean('csv', false)) {
            $csv = "date,total,permit,deny,review\n";
            foreach ($rows as $row) {
                $csv .= \sprintf(
                    "%s,%d,%d,%d,%d\n",
                    $row['date'],
                    $row['total'],
                    $row['permit'],
                    $row['deny'],
                    $row['review']
                );
            }

            return new Response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="compliance-report-daily.csv"',
            ]);
        }

        return new Response(json_encode($rows, \JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
    }
}
