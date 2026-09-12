<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

/**
 * Coordinates the compliance s3 decision export service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceS3DecisionExportService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceDecisionExportService $inner,
        private readonly ComplianceS3ExportClient $s3,
    ) {
    }

    /**
     * Performs the export and upload behavior as part of the owning compliance responsibility.
     */
    public function exportAndUpload(?int $fromId = null): void
    {
        $lines = iterator_to_array($this->inner->exportDecisions($fromId));
        $content = implode('', $lines);
        $this->s3->upload('decision-log-'.date('Ymd-His').'.ndjson', $content);
    }
}
