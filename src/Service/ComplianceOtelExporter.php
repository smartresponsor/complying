<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

use OpenTelemetry\API\Trace\TracerProviderInterface;

final class ComplianceOtelExporter
{
    public function __construct(private readonly TracerProviderInterface $tracerProvider)
    {
    }

    public function span(string $nameEntity, array $attrs = []): void
    {
        $tracer = $this->tracerProvider->getTracer('compliance');
        $span = $tracer->spanBuilder($nameEntity)->startSpan();
        foreach ($attrs as $k => $v) {
            $span->setAttribute($k, (string) $v);
        }
        $span->end();
    }
}
