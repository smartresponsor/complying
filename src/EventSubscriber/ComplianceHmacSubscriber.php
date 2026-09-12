<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\EventSubscriber;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Subscribes to framework events and coordinates the compliance hmac subscriber compliance reaction.
 */
#[AsEventListener(event: RequestEvent::class, method: 'onRequest', priority: 5)]
final class ComplianceHmacSubscriber
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly string $sharedKey,
        private readonly int $tolerance = 120,
    ) {
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

        $sig = $req->headers->get('X-SR-Signature');
        $ts = $req->headers->get('X-SR-Timestamp');
        if (!$sig || !$ts) {
            throw new AccessDeniedHttpException('missing-signature');
        }

        if (abs(time() - (int) $ts) > $this->tolerance) {
            throw new AccessDeniedHttpException('signature-expired');
        }

        $body = $req->getContent() ?: '';
        $calc = hash_hmac('sha256', $ts.':'.$body, $this->sharedKey);
        if (!hash_equals($calc, $sig)) {
            throw new AccessDeniedHttpException('signature-invalid');
        }
    }
}
