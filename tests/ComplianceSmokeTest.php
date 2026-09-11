<?php

declare(strict_types=1);

use App\Complying\Entity\ComplianceKycProfile;
use PHPUnit\Framework\TestCase;

final class ComplianceSmokeTest extends TestCase
{
    public function testKycProfile(): void
    {
        $k = new ComplianceKycProfile(10, ['nameEntity' => 'Acme Vendor']);
        $this->assertSame('pending', $k->getStatus());
    }
}
