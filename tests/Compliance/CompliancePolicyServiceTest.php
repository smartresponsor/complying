<?php

declare(strict_types=1);

namespace App\Complying\Tests\Compliance;

use App\Complying\Mapper\FactMapper;
use App\Complying\Service\CompliancePolicyService;
use PHPUnit\Framework\TestCase;

final class CompliancePolicyServiceTest extends TestCase
{
    public function testServiceCanBeConstructed(): void
    {
        $engine = $this->createMock(\App\Complying\ServiceInterface\Policy\PolicyEngineInterface::class);
        $engine->method('decide')->willReturn(new class {
            public function getOutcome()
            {
                return 'PERMIT';
            }

            public function getPolicyId()
            {
                return 'p1';
            }

            public function getPolicyVersion()
            {
                return 'v1';
            }
        });

        $service = new CompliancePolicyService($engine, new FactMapper());
        $decision = $service->decide('order.created', ['total' => 100]);

        $this->assertSame('PERMIT', $decision->outcome);
    }
}
