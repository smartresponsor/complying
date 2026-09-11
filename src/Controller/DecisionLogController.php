<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Entity\ComplianceDecisionLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DecisionLogController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route(path: '/compliance/decisions', name: 'compliance_decisions', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $repo = $this->em->getRepository(ComplianceDecisionLog::class);
        $items = $repo->findBy([], ['id' => 'DESC'], 100);

        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => $item->getId(),
            ];
        }

        return new JsonResponse($data);
    }
}
