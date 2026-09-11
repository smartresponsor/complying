<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\Context\Context;

final class ComplianceOtelTracer
{
    public function __construct(private readonly TracerInterface $tracer)
    {
    }

    /**
     * @param array<string, scalar|array|null> $attrs
     */
    public function start(string $nameEntity, array $attrs = []): Span
    {
        $spanBuilder = $this->tracer->spanBuilder($nameEntity);
        foreach ($attrs as $k => $v) {
            if (\is_scalar($v)) {
                $spanBuilder->setAttribute($k, $v);
            }
        }

        $span = $spanBuilder->startSpan();
        $span->activate();

        return $span;
    }

    public function end(Span $span): void
    {
        $span->end();
        Context::storage()->detach(Context::storage()->current()); // best-effort
    }
}
