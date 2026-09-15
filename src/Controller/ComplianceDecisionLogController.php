<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller;

use App\Complying\Entity\ComplianceDecisionLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles the compliance decision log controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceDecisionLogController
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
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
