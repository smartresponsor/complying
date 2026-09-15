<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\EventSubscriber;

use App\Complying\Resolver\ComplianceTenantResolver;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Subscribes to framework events and coordinates the compliance tenant request subscriber compliance reaction.
 */
#[AsEventListener(event: RequestEvent::class, method: 'onRequest', priority: 20)]
final class ComplianceTenantRequestSubscriber
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceTenantResolver $resolver)
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

        $tenant = $this->resolver->resolve($req);
        if ($tenant) {
            $req->attributes->set('compliance_tenant_id', $tenant);
        }
    }
}
