<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service\Policy;

use App\Complying\DTO\CompliancePolicyDecisionDTO;
use App\Complying\DTO\CompliancePolicyFactSetDTO;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Coordinates the compliance role policy client responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRolePolicyClient
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $endpoint,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     */
    public function decide(CompliancePolicyFactSetDTO $factSet): CompliancePolicyDecisionDTO
    {
        $response = $this->httpClient->request('POST', $this->endpoint, [
            'json' => $factSet->toArray(),
            'timeout' => 2.5,
        ]);

        $data = $response->toArray(false);

        return CompliancePolicyDecisionDTO::fromArray($data);
    }
}
