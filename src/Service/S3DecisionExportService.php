<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

final class S3DecisionExportService
{
    public function __construct(
        private readonly DecisionExportService $inner,
        private readonly S3ExportClient $s3,
    ) {
    }

    public function exportAndUpload(?int $fromId = null): void
    {
        $lines = iterator_to_array($this->inner->exportDecisions($fromId));
        $content = implode('', $lines);
        $this->s3->upload('decision-log-'.date('Ymd-His').'.ndjson', $content);
    }
}
