<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Hardening;

use App\Complying\DTO\ComplianceDecisionDTO;
use App\Complying\Exception\ComplianceDeniedException;
use App\Complying\Service\ComplianceGuard;
use PHPUnit\Framework\TestCase;

final class ComplianceGuardTest extends TestCase
{
    public function testDenyThrows(): void
    {
        $svc = $this->createMock(\App\Complying\ServiceInterface\CompliancePolicyServiceInterface::class);
        $svc->method('decide')->willReturn(new ComplianceDecisionDTO('DENY', 'p1', 'v1', []));

        $logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $deferred = new \App\Complying\Service\ComplianceDeferredDecisionService(
            $this->createMock(\Symfony\Component\Messenger\MessageBusInterface::class),
            $logger,
        );

        $guard = new ComplianceGuard($svc, $deferred, $logger, false);

        $this->expectException(ComplianceDeniedException::class);
        $guard->guard('order.created', ['id' => 'o1']);
    }
}
