<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\EventSubscriber;

use App\Complying\Service\ComplianceOtelTracer;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

/**
 * Subscribes to framework events and coordinates the compliance otel http subscriber compliance reaction.
 */
#[AsEventListener(event: RequestEvent::class, method: 'onRequest', priority: 10)]
#[AsEventListener(event: TerminateEvent::class, method: 'onTerminate')]
final class ComplianceOtelHttpSubscriber
{
    private ?\OpenTelemetry\API\Trace\SpanInterface $span = null;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceOtelTracer $tracer)
    {
    }

    /**
     * Performs the on request behavior as part of the owning compliance responsibility.
     */
    public function onRequest(RequestEvent $event): void
    {
        $req = $event->getRequest();
        if (!str_starts_with($req->getPathInfo(), '/compliance/')) {
            return;
        }
        $this->span = $this->tracer->start('http.compliance', [
            'path' => $req->getPathInfo(),
            'method' => $req->getMethod(),
        ]);
    }

    /**
     * Performs the on terminate behavior as part of the owning compliance responsibility.
     */
    public function onTerminate(TerminateEvent $event): void
    {
        if ($this->span) {
            $this->span->setAttribute('status_code', $event->getResponse()->getStatusCode());
            $this->tracer->end($this->span);
            $this->span = null;
        }
    }
}
