<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

use OpenTelemetry\API\Trace\TracerProviderInterface;

/**
 * Coordinates the compliance otel exporter responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOtelExporter
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly TracerProviderInterface $tracerProvider)
    {
    }

    /**
     * Performs the span behavior as part of the owning compliance responsibility.
     *
     * @param array<string, bool|float|int|string|null> $attrs */
    public function span(string $nameEntity, array $attrs = []): void
    {
        if ('' === $nameEntity) {
            throw new \InvalidArgumentException('OpenTelemetry span name must not be empty.');
        }

        $tracer = $this->tracerProvider->getTracer('compliance');
        $span = $tracer->spanBuilder($nameEntity)->startSpan();
        foreach ($attrs as $key => $value) {
            if ('' === $key || null === $value) {
                continue;
            }

            $span->setAttribute($key, $value);
        }
        $span->end();
    }
}
