<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Service\ComplianceConfigService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance config controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceConfigController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceConfigService $service)
    {
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/compliance/config', name: 'compliance_config_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse($this->service->list());
    }

    /**
     * Returns the get value exposed by this compliance responsibility.
     */
    #[Route(path: '/compliance/config/{slug}', name: 'compliance_config_get', methods: ['GET'])]
    public function get(string $slug): JsonResponse
    {
        $cfg = $this->service->get($slug);
        if (!$cfg) {
            return new JsonResponse(['error' => 'not found'], 404);
        }

        return new JsonResponse([
            'key' => $cfg->getKeyName(),
            'value' => $cfg->getValue(),
            'scope' => $cfg->getScope(),
            'updated_at' => $cfg->getUpdatedAt()?->format(\DATE_ATOM),
        ]);
    }

    /**
     * Updates the set value while preserving the owning compliance invariant.
     */
    #[Route(path: '/compliance/config/{slug}', name: 'compliance_config_put', methods: ['PUT', 'POST'])]
    public function set(string $slug, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $value = $data['value'] ?? null;
        $scope = $data['scope'] ?? null;

        $cfg = $this->service->set($slug, $value, $scope);

        return new JsonResponse([
            'key' => $cfg->getKeyName(),
            'value' => $cfg->getValue(),
            'scope' => $cfg->getScope(),
            'updated_at' => $cfg->getUpdatedAt()?->format(\DATE_ATOM),
        ]);
    }
}
