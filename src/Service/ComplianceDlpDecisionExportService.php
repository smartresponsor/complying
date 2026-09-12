<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

/**
 * Coordinates the compliance dlp decision export service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDlpDecisionExportService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceDecisionExportService $inner,
        private readonly ComplianceDlpRedactor $dlp,
        private readonly bool $keepRaw = false,
    ) {
    }

    /**
     * Performs the export decisions behavior as part of the owning compliance responsibility.
     *
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
