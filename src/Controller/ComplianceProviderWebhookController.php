<?php

declare(strict_types=1);

namespace App\Complying\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles the compliance provider webhook controller HTTP boundary and delegates compliance behavior to application services.
 */
final class ComplianceProviderWebhookController
{
    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    public function __invoke(Request $request): Response
    {
        return new Response('ok', 200);
    }
}
