<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Entity\ComplianceCaseQueue;
use App\Complying\Entity\ComplianceConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(name: 'compliance:fixtures:load', description: 'Load demo fixtures for compliance')]
final class ComplianceFixturesLoadCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly string $fixturesDir = __DIR__.'/../../../../fixtures/compliance')
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = Yaml::parseFile($this->fixturesDir.'/config.yaml');
        foreach ($config['config'] ?? [] as $key => $val) {
            $cfg = new ComplianceConfig($key, (string) $val, 'demo');
            $this->em->persist($cfg);
        }

        $cases = Yaml::parseFile($this->fixturesDir.'/cases.yaml');
        foreach ($cases['cases'] ?? [] as $row) {
            $c = new ComplianceCaseQueue();
            $c->setObjectId($row['object_id']);
            $c->setStatus($row['status']);
            $this->em->persist($c);
        }

        $this->em->flush();
        $output->writeln('demo fixtures loaded');

        return Command::SUCCESS;
    }
}
