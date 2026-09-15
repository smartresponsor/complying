<?php

declare(strict_types=1);

namespace App\Complying\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * Subscribes to framework events and coordinates the compliance order placed subscriber compliance reaction.
 */
#[AsEventListener(event: 'order.placed')]
final class ComplianceOrderPlacedSubscriber
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * Performs the invoke behavior as part of the owning compliance responsibility.
     */
    public function __invoke(): void
    {
        $this->logger->info('Compliance check hook for order.placed (AML/KYC/risk)');
    }
}
