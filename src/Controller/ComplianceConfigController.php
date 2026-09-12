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

final class ComplianceConfigController
{
    public function __construct(private readonly ComplianceConfigService $service)
    {
    }

    #[Route(path: '/compliance/config', name: 'compliance_config_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse($this->service->list());
    }

    #[Route(path: '/compliance/config/{key}', name: 'compliance_config_get', methods: ['GET'])]
    public function get(string $key): JsonResponse
    {
        $cfg = $this->service->get($key);
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

    #[Route(path: '/compliance/config/{key}', name: 'compliance_config_put', methods: ['PUT', 'POST'])]
    public function set(string $key, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $value = $data['value'] ?? null;
        $scope = $data['scope'] ?? null;

        $cfg = $this->service->set($key, $value, $scope);

        return new JsonResponse([
            'key' => $cfg->getKeyName(),
            'value' => $cfg->getValue(),
            'scope' => $cfg->getScope(),
            'updated_at' => $cfg->getUpdatedAt()?->format(\DATE_ATOM),
        ]);
    }
}
