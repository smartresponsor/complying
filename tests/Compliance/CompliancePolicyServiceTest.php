<?php

declare(strict_types=1);

namespace App\Complying\Tests\Compliance;

use App\Complying\Mapper\FactMapper;
use App\Complying\Service\CompliancePolicyService;
use App\Complying\Service\Policy\RolePolicyClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

final class CompliancePolicyServiceTest extends TestCase
{
    public function testServiceCanBeConstructed(): void
    {
        $httpClient = new MockHttpClient(new MockResponse(json_encode([
            'outcome' => 'PERMIT',
            'policy_id' => 'p1',
            'policy_version' => 'v1',
        ], \JSON_THROW_ON_ERROR)));
        $client = new RolePolicyClient($httpClient, 'https://compliance.invalid/policy');

        $service = new CompliancePolicyService($client, new FactMapper());
        $decision = $service->decide('order.created', ['total' => 100]);

        $this->assertSame('PERMIT', $decision->outcome);
    }
}
