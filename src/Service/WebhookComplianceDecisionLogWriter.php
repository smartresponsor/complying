<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\DTO\ComplianceDecisionDTO;

final class WebhookComplianceDecisionLogWriter
{
    public function __construct(
        private readonly ComplianceDecisionLogWriter $inner,
        private readonly WebhookNotifier $notifier,
        private readonly bool $onlyOnIncident = true,
    ) {
    }

    public function write(ComplianceDecisionDTO $decision, ?string $objectId, string $eventName): void
    {
        $this->inner->write($decision, $objectId, $eventName);

        if ($this->onlyOnIncident && !\in_array($decision->outcome, ['DENY', 'REVIEW'], true)) {
            return;
        }

        $this->notifier->send([
            'event' => $eventName,
            'outcome' => $decision->outcome,
            'object_id' => $objectId,
            'policy_id' => $decision->policyId,
            'policy_version' => $decision->policyVersion,
            'facts' => $decision->facts,
        ]);
    }
}
