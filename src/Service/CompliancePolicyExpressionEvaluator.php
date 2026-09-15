<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Coordinates the compliance policy expression evaluator responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePolicyExpressionEvaluator
{
    private ExpressionLanguage $el;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct()
    {
        $this->el = new ExpressionLanguage();
    }

    /**
     * Performs the evaluate behavior as part of the owning compliance responsibility.
     *
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
