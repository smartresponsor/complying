<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class PolicyExpressionEvaluator
{
    private ExpressionLanguage $el;

    public function __construct()
    {
        $this->el = new ExpressionLanguage();
    }

    /**
     * @param array<string, mixed> $facts
     */
    public function evaluate(string $expression, array $facts): bool
    {
        return (bool) $this->el->evaluate($expression, [
            'facts' => $facts,
            // shortcuts
            'country' => $facts['country'] ?? null,
            'amount' => $facts['amount'] ?? null,
            'is_sanctioned' => $facts['is_sanctioned'] ?? null,
            'manual_review' => $facts['manual_review'] ?? null,
        ]);
    }
}
