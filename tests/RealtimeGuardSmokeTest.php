<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class RealtimeGuardSmokeTest extends TestCase
{
    public function testConstants(): void
    {
        $this->assertSame('ALLOW', App\Complying\Service\ComplianceRealtimeGuard::ALLOW);
        $this->assertSame('REVIEW', App\Complying\Service\ComplianceRealtimeGuard::REVIEW);
        $this->assertSame('DENY', App\Complying\Service\ComplianceRealtimeGuard::DENY);
    }
}
