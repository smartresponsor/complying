<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\ServiceInterface\SanctionImportServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'compliance:sanction:import', description: 'Import sanction list from JSON file')]
final class SanctionImportCommand extends Command
{
    public function __construct(private readonly SanctionImportServiceInterface $service)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Path to JSON file');
    }

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
