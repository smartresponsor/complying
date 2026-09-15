<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\ComplianceIncidentWebhookService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance incident webhook retry command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'compliance:webhook:retry', description: 'Retry failed compliance webhooks')]
final class ComplianceIncidentWebhookRetryCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceIncidentWebhookService $service)
    {
        parent::__construct();
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sent = $this->service->retry(20);
        $output->writeln('Sent: '.$sent);

        return Command::SUCCESS;
    }
}
