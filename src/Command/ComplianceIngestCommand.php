<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\Provider\ComplianceComplyAdvantageClient;
use App\Complying\Service\Provider\ComplianceOnfidoClient;
use App\Complying\Service\Provider\ComplianceSumsubClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exposes the compliance ingest command console operation for controlled compliance administration and automation.
 */
#[AsCommand(name: 'app:compliance:ingest', description: 'Ingest payload from a provider (sumsub|onfido|comply)')]
final class ComplianceIngestCommand extends Command
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceSumsubClient $sumsub,
        private readonly ComplianceOnfidoClient $onfido,
        private readonly ComplianceComplyAdvantageClient $comply,
    ) {
        parent::__construct();
    }

    /**
     * Defines the command name, arguments, options, and operator-facing description.
     */
    protected function configure(): void
    {
        $this->addArgument('provider', InputArgument::REQUIRED);
        $this->addArgument('payload', InputArgument::REQUIRED, 'JSON string payload');
    }

    /**
     * Executes the configured console workflow and returns its process status code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $provider = strtolower((string) $input->getArgument('provider'));
        $payload = json_decode((string) $input->getArgument('payload'), true) ?? [];

        $res = match ($provider) {
            'sumsub' => $this->sumsub->verify($payload),
            'onfido' => $this->onfido->verify($payload),
            'comply', 'complyadvantage' => $this->comply->screen($payload),
            default => ['error' => 'unknown provider'],
        };

        $output->writeln(json_encode($res, \JSON_PRETTY_PRINT | \JSON_THROW_ON_ERROR));

        return Command::SUCCESS;
    }
}
