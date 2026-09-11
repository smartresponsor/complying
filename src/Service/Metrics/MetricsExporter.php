<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service\Metrics;

use Doctrine\DBAL\Connection;

final class MetricsExporter
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function collect(): string
    {
        $decisions = (int) $this->connection->fetchOne('SELECT COUNT(*) FROM compliance_decision_log');
        $openCases = (int) $this->connection->fetchOne("SELECT COUNT(*) FROM compliance_case_queue WHERE status = 'new'");

        $lines = [];
        $lines[] = '# HELP sr_compliance_decisions_total Total decisions made by compliance';
        $lines[] = '# TYPE sr_compliance_decisions_total counter';
        $lines[] = 'sr_compliance_decisions_total '.$decisions;
        $lines[] = '# HELP sr_compliance_cases_open Open compliance cases';
        $lines[] = '# TYPE sr_compliance_cases_open gauge';
        $lines[] = 'sr_compliance_cases_open '.$openCases;

        return implode("\n", $lines)."\n";
    }
}
