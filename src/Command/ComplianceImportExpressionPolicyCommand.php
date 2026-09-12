<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Exposes the compliance import expression policy command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'compliance:policy:import-expr', description: 'Import expression-based compliance policies from yaml')]
final class ComplianceImportExpressionPolicyCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'yaml file with policies');
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $data = Yaml::parseFile($file);
        foreach ($data['policies'] ?? [] as $row) {
            $this->connection->executeStatement(
                "INSERT INTO compliance_policy_registry (policy_id, policy_version, description, source) VALUES (:id, 'v1', :expr, 'expression')
                ON CONFLICT (policy_id) DO UPDATE SET description = EXCLUDED.description, source = EXCLUDED.source",
                [
                    'id' => $row['policy_id'],
                    'expr' => $row['expression'],
                ]
            );
            $output->writeln('imported '.$row['policy_id']);
        }

        return Command::SUCCESS;
    }
}
