<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Entity\ComplianceRetentionPolicyEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance retention controller HTTP boundary and delegates compliance behavior to application services.
 */
#[Route(path: '/compliance/admin/retention')]
final class ComplianceRetentionController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $items = $this->em->getRepository(ComplianceRetentionPolicyEntity::class)->findAll();

        return new JsonResponse(array_map(static function (ComplianceRetentionPolicyEntity $p): array {
            return [
                'id' => $p->getId(),
                'resource' => $p->getResource(),
                'days' => $p->getDays(),
            ];
        }, $items));
    }

    /**
     * Performs the create behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true) ?? [];
        $p = new ComplianceRetentionPolicyEntity($data['resource'] ?? 'decision_log', (int) ($data['days'] ?? 30));
        $this->em->persist($p);
        $this->em->flush();

        return new JsonResponse(['id' => $p->getId()], 201);
    }

    /**
     * Performs the update behavior as part of the owning compliance responsibility.
     */
    #[Route(path: '/policy/{id}', methods: ['PUT'])]
    public function update(int $id, Request $req): JsonResponse
    {
        $p = $this->em->find(ComplianceRetentionPolicyEntity::class, $id);
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
