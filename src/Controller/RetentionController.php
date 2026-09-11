<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Entity\ComplianceRetentionPolicy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/compliance/admin/retention')]
final class RetentionController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route(path: '', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $items = $this->em->getRepository(ComplianceRetentionPolicy::class)->findAll();

        return new JsonResponse(array_map(static function (ComplianceRetentionPolicy $p): array {
            return [
                'id' => $p->getId(),
                'resource' => $p->getResource(),
                'days' => $p->getDays(),
            ];
        }, $items));
    }

    #[Route(path: '', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true) ?? [];
        $p = new ComplianceRetentionPolicy($data['resource'] ?? 'decision_log', (int) ($data['days'] ?? 30));
        $this->em->persist($p);
        $this->em->flush();

        return new JsonResponse(['id' => $p->getId()], 201);
    }

    #[Route(path: '/{id}', methods: ['PUT'])]
    public function update(int $id, Request $req): JsonResponse
    {
        $p = $this->em->find(ComplianceRetentionPolicy::class, $id);
        if (!$p) {
            return new JsonResponse(['error' => 'not_found'], 404);
        }
        $data = json_decode($req->getContent(), true) ?? [];
        if (isset($data['days'])) {
            $p->setDays((int) $data['days']);
        }
        $this->em->flush();

        return new JsonResponse(['ok' => true]);
    }
}
