<?php

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceRiskRule;
use Doctrine\ORM\EntityManagerInterface;

final class RiskEngine
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function evaluate(array $facts): float
    {
        $repo = $this->em->getRepository(ComplianceRiskRule::class);
        $rules = $repo->findBy(['active' => true]);
        $score = 0.0;

        foreach ($rules as $rule) {
            $dsl = json_decode($rule->getDsl(), true);
            if (!\is_array($dsl) || !isset($dsl['if'])) {
                continue;
            }
            $ok = true;
            for ($i = 0; $i < \count($dsl['if']); ++$i) {
                $cond = $dsl['if'][$i];
                $field = $cond['field'] ?? null;
                $op = $cond['op'] ?? '==';
                $val = $cond['value'] ?? null;
                $fact = $facts[$field] ?? null;
                $ok = $ok && $this->compare($fact, $op, $val);
                if (!$ok) {
                    break;
                }
            }
            if ($ok) {
                $score += (float) ($dsl['weight'] ?? $rule->getScore());
            }
        }

        return min(100.0, $score);
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
