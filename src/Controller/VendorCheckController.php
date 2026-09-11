<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\ServiceInterface\CompliancePolicyServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class VendorCheckController
{
    public function __construct(private readonly CompliancePolicyServiceInterface $service)
    {
    }

    #[Route(path: '/compliance/check-vendor', name: 'compliance_check_vendor', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];
        $decision = $this->service->decide('vendor.created', $payload);

        return new JsonResponse([
            'outcome' => $decision->outcome,
            'policy_id' => $decision->policyId,
            'policy_version' => $decision->policyVersion,
        ]);
    }
}
