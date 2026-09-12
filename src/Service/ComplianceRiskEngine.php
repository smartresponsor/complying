<?php

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceRiskRule;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance risk engine responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceRiskEngine
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the evaluate behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $facts */
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
                $ok = $this->compare($fact, $op, $val);
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
