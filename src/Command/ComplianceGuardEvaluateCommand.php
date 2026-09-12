<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\ComplianceRealtimeGuard;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance guard evaluate command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'app:guard:evaluate', description: 'Evaluate realtime compliance guard for a payment')]
final class ComplianceGuardEvaluateCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly ComplianceRealtimeGuard $guard)
    {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('vendorId', InputArgument::REQUIRED);
        $this->addArgument('amountMinor', InputArgument::REQUIRED);
        $this->addArgument('facts', InputArgument::OPTIONAL, 'JSON-encoded extra facts', '{}');
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vendorId = (int) $input->getArgument('vendorId');
        $amount = (int) $input->getArgument('amountMinor');
        $facts = json_decode((string) $input->getArgument('facts'), true) ?: [];
        $res = $this->guard->decide(array_merge($facts, ['vendor_id' => $vendorId, 'amount_minor' => $amount]));
        $output->writeln(json_encode($res, \JSON_PRETTY_PRINT | \JSON_THROW_ON_ERROR));

        return Command::SUCCESS;
    }
}
