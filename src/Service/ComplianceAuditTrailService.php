<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceAuditLog;
use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Coordinates the compliance audit trail service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceAuditTrailService implements ComplianceAuditTrailServiceInterface
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * Performs the add behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $payload
     */
    public function add(string $action, array $payload = []): void
    {
        $req = $this->requestStack->getCurrentRequest();
        $actor = $req?->headers->get('X-User') ?? $req?->getUser();
        $ip = $req?->getClientIp();

        $log = new ComplianceAuditLog($action, $actor, $ip, $payload);
        $this->em->persist($log);
        $this->em->flush();
    }
}
