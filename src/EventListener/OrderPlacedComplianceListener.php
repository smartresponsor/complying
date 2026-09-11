<?php

declare(strict_types=1);

namespace App\Complying\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\CommerceAttributeEntity\AsEventListener;

#[AsEventListener(event: 'order.placed')]
final class OrderPlacedComplianceListener
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(): void
    {
        $this->logger->info('Compliance check hook for order.placed (AML/KYC/risk)');
    }
}
