<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\ServiceInterface\ComplianceSanctionImportServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance sanction import command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'compliance:sanction:import', description: 'Import sanction list from JSON file')]
final class ComplianceSanctionImportCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceSanctionImportServiceInterface $service)
    {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Path to JSON file');
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $content = file_get_contents($file);
        $data = json_decode($content ?: '[]', true) ?? [];

        $count = $this->service->import($data);
        $output->writeln('Imported: '.$count);

        return Command::SUCCESS;
    }
}
