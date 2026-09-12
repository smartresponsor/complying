<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\RealtimeGuard;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:guard:evaluate', description: 'Evaluate realtime compliance guard for a payment')]
final class GuardEvaluateCommand extends Command
{
    public function __construct(private readonly RealtimeGuard $guard)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('vendorId', InputArgument::REQUIRED);
        $this->addArgument('amountMinor', InputArgument::REQUIRED);
        $this->addArgument('facts', InputArgument::OPTIONAL, 'JSON-encoded extra facts', '{}');
    }

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
