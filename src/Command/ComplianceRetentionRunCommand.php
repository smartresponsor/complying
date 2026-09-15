<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\ComplianceRetentionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance retention run command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'compliance:retention:run', description: 'Archive old compliance decisions')]
final class ComplianceRetentionRunCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceRetentionService $service)
    {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('days', InputArgument::OPTIONAL, 'Archive older than N days', '90');
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $days = (int) $input->getArgument('days');
        $archived = $this->service->archiveOlderThan($days);

        $output->writeln('Archived rows: '.$archived);

        return Command::SUCCESS;
    }
}
