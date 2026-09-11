<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Controller;

use App\Complying\Service\ConsentChecker;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/compliance/consent')]
final class ConsentController
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ConsentChecker $checker,
    ) {
    }

    #[Route(path: '', methods: ['POST'])]
    public function grant(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $user = $data['user_id'] ?? '';
        $purpose = $data['purpose'] ?? '';
        $this->connection->insert('compliance_consent', [
            'user_id' => $user,
            'purpose' => $purpose,
            'granted_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'withdrawn_at' => null,
        ]);

        return new JsonResponse(['ok' => true]);
    }

    #[Route(path: '/withdraw', methods: ['POST'])]
    public function withdraw(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $user = $data['user_id'] ?? '';
        $purpose = $data['purpose'] ?? '';
        $this->connection->insert('compliance_consent', [
            'user_id' => $user,
            'purpose' => $purpose,
            'granted_at' => null,
            'withdrawn_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ]);

        return new JsonResponse(['ok' => true]);
    }

    #[Route(path: '/check', methods: ['GET'])]
    public function check(Request $request): JsonResponse
    {
        $user = (string) $request->query->get('user_id');
        $purpose = (string) $request->query->get('purpose');

        return new JsonResponse(['allowed' => $this->checker->hasConsent($user, $purpose)]);
    }
}
