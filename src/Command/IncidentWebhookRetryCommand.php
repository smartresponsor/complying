<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\IncidentWebhookService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'compliance:webhook:retry', description: 'Retry failed compliance webhooks')]
final class IncidentWebhookRetryCommand extends Command
{
    public function __construct(private readonly IncidentWebhookService $service)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sent = $this->service->retry(20);
        $output->writeln('Sent: '.$sent);

        return Command::SUCCESS;
    }
}
