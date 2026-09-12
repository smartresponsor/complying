<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Aws\S3\S3Client;
use Psr\Log\LoggerInterface;

/**
 * Coordinates the compliance s3 export client responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceS3ExportClient
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly S3Client $client,
        private readonly LoggerInterface $logger,
        private readonly string $bucket,
        private readonly string $prefix = 'compliance/',
    ) {
    }

    /**
     * Performs the upload behavior as part of the owning compliance responsibility.
     */
    public function upload(string $key, string $content): void
    {
        $fullKey = rtrim($this->prefix, '/').'/'.ltrim($key, '/');
        try {
            $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $fullKey,
                'Body' => $content,
                'ContentType' => 'application/x-ndjson',
            ]);
        } catch (\Throwable $e) {
            $this->logger->error('s3 export failed', ['key' => $fullKey, 'error' => $e->getMessage()]);
        }
    }
}
