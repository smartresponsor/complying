<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\ComplianceCaseWorkerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'compliance:case:process', description: 'Process compliance case queue')]
final class ComplianceCaseProcessCommand extends Command
{
    public function __construct(private readonly ComplianceCaseWorkerService $service)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('limit', InputArgument::OPTIONAL, 'How many to process', '50');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = (int) $input->getArgument('limit');
        $count = $this->service->process($limit);

        $output->writeln('Processed cases: '.$count);

        return Command::SUCCESS;
    }
}
