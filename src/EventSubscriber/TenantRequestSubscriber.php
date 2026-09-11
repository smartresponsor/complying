<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\EventSubscriber;

use App\Complying\Service\TenantResolver;
use Symfony\Component\EventDispatcher\CommerceAttributeEntity\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener(event: RequestEvent::class, method: 'onRequest', priority: 20)]
final class TenantRequestSubscriber
{
    public function __construct(private readonly TenantResolver $resolver)
    {
    }

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
