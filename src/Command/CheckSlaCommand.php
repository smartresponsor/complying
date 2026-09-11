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

#[AsCommand(name: 'compliance:case:check-sla')]
final class CheckSlaCommand extends Command
{
    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = $this->connection->fetchAllAssociative(
            "SELECT id, object_id FROM compliance_case_queue WHERE status='REVIEW' AND deadline_at < NOW()"
        );
        foreach ($rows as $row) {
            $output->writeln('SLA breach: '.$row['object_id']);
        }

        return Command::SUCCESS;
    }
}
