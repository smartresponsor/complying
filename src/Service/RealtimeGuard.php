<?php

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceDecisionLog;
use Doctrine\ORM\EntityManagerInterface;

final class RealtimeGuard
{
    public const ALLOW = 'ALLOW';
    public const REVIEW = 'REVIEW';
    public const DENY = 'DENY';

    public function __construct(
        private readonly PolicyRepository $policies,
        private readonly RiskScorer $risk,
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * @param array<string,mixed> $facts expects amount_minor, vendor_id, country, etc
     *
     * @return array{decision:string, reasons:array}
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
                $ok = $ok && $this->compare($factVal, $op, $val);
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
        $log = new ComplianceDecisionLog($vendorId, $decision, $facts, $reasons);
        $this->em->persist($log);
        $this->em->flush();

        return ['decision' => $decision, 'reasons' => $reasons];
    }

    private function compare($a, string $op, $b): bool
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
