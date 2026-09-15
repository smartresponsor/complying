<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance check sla command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'compliance:case:check-sla')]
final class ComplianceCheckSlaCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = $this->connection->fetchAllAssociative(
            "SELECT id, target_id AS object_id FROM compliance_case_queue WHERE status='REVIEW' AND deadline_at < NOW()"
        );
        foreach ($rows as $row) {
            $output->writeln('SLA breach: '.$row['object_id']);
        }

        return Command::SUCCESS;
    }
}
