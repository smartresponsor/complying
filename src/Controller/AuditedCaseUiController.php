<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\CaseQueueServiceInterface;
use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class AuditedCaseUiController
{
    public function __construct(
        private readonly CaseQueueServiceInterface $service,
        private readonly ComplianceAuditTrailServiceInterface $audit,
    ) {
    }

    #[Route(path: '/admin/compliance/cases/{id}/close-audited', name: 'admin_compliance_case_close_audited', methods: ['POST'])]
    public function close(int $id, Request $request): RedirectResponse
    {
        $actor = (string) $request->headers->get('X-User', 'admin');
        $this->service->close($id, $actor);
        $this->audit->add('compliance.case.close', ['id' => $id, 'actor' => $actor]);

        return new RedirectResponse('/admin/compliance/cases');
    }
}
