<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\TracerInterface;

/**
 * Coordinates the compliance otel tracer responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceOtelTracer
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly TracerInterface $tracer)
    {
    }

    /**
     * Performs the start behavior as part of the owning compliance responsibility.
     *
     * @param array<string, bool|float|int|string|null> $attrs
     */
    public function start(string $nameEntity, array $attrs = []): SpanInterface
    {
        if ('' === $nameEntity) {
            throw new \InvalidArgumentException('OpenTelemetry span name must not be empty.');
        }

        $spanBuilder = $this->tracer->spanBuilder($nameEntity);
        foreach ($attrs as $key => $value) {
            if ('' === $key || null === $value) {
                continue;
            }

            $spanBuilder->setAttribute($key, $value);
        }

        return $spanBuilder->startSpan();
    }

    /**
     * Performs the end behavior as part of the owning compliance responsibility.
     */
    public function end(SpanInterface $span): void
    {
        $span->end();
    }
}
