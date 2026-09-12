<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\ComplianceLimitEvaluator;
use App\Complying\Service\ComplianceRiskScorer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance scan command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'app:compliance:scan', description: 'Run risk score and limit evaluation for a vendor')]
final class ComplianceScanCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceRiskScorer $risk,
        private readonly ComplianceLimitEvaluator $limits,
    ) {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('vendorId', InputArgument::REQUIRED);
        $this->addArgument('dailyLimitMinor', InputArgument::REQUIRED);
        $this->addArgument('monthlyLimitMinor', InputArgument::REQUIRED);
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vendorId = (int) $input->getArgument('vendorId');
        $d = (int) $input->getArgument('dailyLimitMinor');
        $m = (int) $input->getArgument('monthlyLimitMinor');

        $score = $this->risk->scoreVendor($vendorId);
        $limits = $this->limits->evaluate($vendorId, $d, $m);

        $output->writeln(\sprintf('RiskScore=%.2f  Limits: ok=%s daily_used=%d monthly_used=%d',
            $score, $limits['ok'] ? 'true' : 'false', $limits['daily'], $limits['monthly']
        ));

        return Command::SUCCESS;
    }
}
