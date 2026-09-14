<?php

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceDecisionLog;
use App\Complying\Repository\CompliancePolicyRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance realtime guard responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRealtimeGuard
{
    public const ALLOW = 'ALLOW';
    public const REVIEW = 'REVIEW';
    public const DENY = 'DENY';

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly CompliancePolicyRepository $policies,
        private readonly ComplianceRiskScorer $risk,
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * Performs the decide behavior as part of the owning compliance responsibility.
     *
     * @param array<string,mixed> $facts expects amount_minor, vendor_id, country, etc
     *
     * @return array{decision: string, reasons: list<string>}
     */
    public function decide(array $facts): array
    {
        // enrich facts with risk score
        $vendorId = (int) ($facts['vendor_id'] ?? 0);
        $facts['risk_score'] = $this->risk->scoreVendor($vendorId);

        $policy = $this->policies->load('default');
        $decision = self::ALLOW;
        $reasons = ['Default allow'];

        foreach ($policy['rules'] ?? [] as $rule) {
            $ok = true;
            foreach ($rule['if'] as $cond) {
                $field = $cond['field'] ?? null;
                $op = $cond['op'] ?? '==';
                $val = $cond['value'] ?? null;
                $factVal = $facts[$field] ?? null;
                $ok = $this->compare($factVal, $op, $val);
                if (!$ok) {
                    break;
                }
            }
            if ($ok) {
                $decision = strtoupper((string) $rule['decision']);
                $reasons = [(string) ($rule['reason'] ?? $rule['nameEntity'] ?? 'policy')];
                break;
            }
        }

        // persist log
        $logFacts = $facts;
        $logFacts['reasons'] = $reasons;
        $log = new ComplianceDecisionLog(
            $decision,
            $logFacts,
            targetId: (string) $vendorId,
            eventName: 'compliance.realtime',
        );
        $this->em->persist($log);
        $this->em->flush();

        return ['decision' => $decision, 'reasons' => $reasons];
    }

    /**
     * Performs the compare behavior as part of the owning compliance responsibility.
     */
    private function compare(mixed $a, string $op, mixed $b): bool
    {
        return match ($op) {
            '==' => $a == $b,
            '!=' => $a != $b,
            '>' => $a > $b,
            '>=' => $a >= $b,
            '<' => $a < $b,
            '<=' => $a <= $b,
            'in' => \is_array($b) && \in_array($a, $b, true),
            default => false,
        };
    }
}
