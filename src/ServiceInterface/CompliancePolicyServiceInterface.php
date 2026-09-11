<?php

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

use App\Complying\DTO\ComplianceDecisionDTO;

interface CompliancePolicyServiceInterface
{
    public function decide(string $eventName, array $payload): ComplianceDecisionDTO;
}
