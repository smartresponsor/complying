<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\PolicyRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:policy:lint', description: 'Validate policy JSON structure')]
final class PolicyLintCommand extends Command
{
    public function __construct(private readonly PolicyRepository $repo)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('nameEntity', InputArgument::OPTIONAL, 'policy nameEntity', 'default');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $nameEntity = (string) $input->getArgument('nameEntity');
        $p = $this->repo->load($nameEntity);
        if (!isset($p['rules']) || !\is_array($p['rules'])) {
            $output->writeln('<error>Invalid policy: missing rules</error>');

            return Command::FAILURE;
        }
        $output->writeln(\sprintf('<info>Policy "%s" OK, %d rules.</info>', $nameEntity, \count($p['rules'])));

        return Command::SUCCESS;
    }
}
