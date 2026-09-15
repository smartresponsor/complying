<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;
use App\Complying\ServiceInterface\ComplianceCaseQueueServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance audited case ui controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceAuditedCaseUiController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceCaseQueueServiceInterface $service,
        private readonly ComplianceAuditTrailServiceInterface $audit,
    ) {
    }

    /**
     * Performs the close behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/admin/compliance/cases/close/audited/{id}', name: 'admin_compliance_case_close_audited', methods: ['POST'])]
    public function close(int $id, Request $request): RedirectResponse
    {
        $actor = (string) $request->headers->get('X-User', 'admin');
        $this->service->close($id, $actor);
        $this->audit->add('compliance.case.close', ['id' => $id, 'actor' => $actor]);

        return new RedirectResponse('/admin/compliance/cases');
    }
}
