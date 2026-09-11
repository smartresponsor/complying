<?php

declare(strict_types=1);

namespace App\Complying\Command;

use App\Complying\Service\Provider\ComplyAdvantageClient;
use App\Complying\Service\Provider\OnfidoClient;
use App\Complying\Service\Provider\SumsubClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:compliance:ingest', description: 'Ingest payload from a provider (sumsub|onfido|comply)')]
final class ComplianceIngestCommand extends Command
{
    public function __construct(
        private readonly SumsubClient $sumsub,
        private readonly OnfidoClient $onfido,
        private readonly ComplyAdvantageClient $comply,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('provider', InputArgument::REQUIRED);
        $this->addArgument('payload', InputArgument::REQUIRED, 'JSON string payload');
    }

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

        $output->writeln(json_encode($res, \JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
