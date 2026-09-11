<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

final class MetricsRegistry
{
    /** @var array<string, int> */
    private array $counters = [
        'compliance_decisions_total' => 0,
        'compliance_cases_open' => 0,
        'compliance_import_fail_total' => 0,
    ];

    public function incDecision(): void
    {
        ++$this->counters['compliance_decisions_total'];
    }

    public function setCasesOpen(int $count): void
    {
        $this->counters['compliance_cases_open'] = $count;
    }

    public function incImportFail(): void
    {
        ++$this->counters['compliance_import_fail_total'];
    }

    public function export(): string
    {
        $lines = [];
        $lines[] = '# HELP compliance_decisions_total Total compliance decisions';
        $lines[] = '# TYPE compliance_decisions_total counter';
        $lines[] = 'compliance_decisions_total '.$this->counters['compliance_decisions_total'];

        $lines[] = '# HELP compliance_cases_open Open compliance cases';
        $lines[] = '# TYPE compliance_cases_open gauge';
        $lines[] = 'compliance_cases_open '.$this->counters['compliance_cases_open'];

        $lines[] = '# HELP compliance_import_fail_total Failed imports';
        $lines[] = '# TYPE compliance_import_fail_total counter';
        $lines[] = 'compliance_import_fail_total '.$this->counters['compliance_import_fail_total'];

        return implode("\n", $lines)."\n";
    }
}
