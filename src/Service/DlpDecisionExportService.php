<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

final class DlpDecisionExportService
{
    public function __construct(
        private readonly DecisionExportService $inner,
        private readonly DlpRedactor $dlp,
        private readonly bool $keepRaw = false,
    ) {
    }

    /**
     * @return \Generator<string>
     */
    public function exportDecisions(?int $fromId = null, ?\DateTimeImmutable $fromDate = null): \Generator
    {
        foreach ($this->inner->exportDecisions($fromId, $fromDate) as $line) {
            $row = json_decode($line, true);
            if (\is_array($row) && isset($row['facts']) && !$this->keepRaw) {
                $row['facts'] = $this->dlp->redactArray($row['facts']);
                yield json_encode($row, \JSON_UNESCAPED_UNICODE)."\n";
            } else {
                yield $line;
            }
        }
    }
}
