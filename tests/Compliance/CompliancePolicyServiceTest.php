<?php

declare(strict_types=1);

namespace App\Complying\Tests\Compliance;

use App\Complying\Service\CompliancePolicyEvaluationService;
use App\Complying\Service\Mapping\ComplianceFactMappingService;
use App\Complying\Service\Policy\ComplianceRolePolicyClient;
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
        $client = new ComplianceRolePolicyClient($httpClient, 'https://compliance.invalid/policy');

        $service = new CompliancePolicyEvaluationService($client, new ComplianceFactMappingService());
        $decision = $service->decide('order.created', ['total' => 100]);

        $this->assertSame('PERMIT', $decision->outcome);
    }
}
