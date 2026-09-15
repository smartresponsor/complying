<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Repository\CompliancePolicyRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance policy lint command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'app:policy:lint', description: 'Validate policy JSON structure')]
final class CompliancePolicyLintCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly CompliancePolicyRepository $repo)
    {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('nameEntity', InputArgument::OPTIONAL, 'policy nameEntity', 'default');
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
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
