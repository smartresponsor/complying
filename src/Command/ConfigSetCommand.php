<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'compliance:config:set')]
final class ConfigSetCommand extends Command
{
    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('key', InputArgument::REQUIRED);
        $this->addArgument('value', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $key = $input->getArgument('key');
        $value = $input->getArgument('value');

        $this->connection->executeStatement(
            "INSERT INTO compliance_config(key,value,source) VALUES(:k,:v,'cli')
             ON CONFLICT (key) DO UPDATE SET value=EXCLUDED.value, source=EXCLUDED.source",
            ['k' => $key, 'v' => $value]
        );
        $output->writeln('ok');

        return Command::SUCCESS;
    }
}
