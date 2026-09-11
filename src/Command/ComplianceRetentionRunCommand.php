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

#[AsCommand(name: 'compliance:retention:run', description: 'Archive old compliance decisions')]
final class ComplianceRetentionRunCommand extends Command
{
    public function __construct(private readonly ComplianceRetentionService $service)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('days', InputArgument::OPTIONAL, 'Archive older than N days', '90');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $days = (int) $input->getArgument('days');
        $archived = $this->service->archiveOlderThan($days);

        $output->writeln('Archived rows: '.$archived);

        return Command::SUCCESS;
    }
}
