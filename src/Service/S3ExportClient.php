<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use Aws\S3\S3Client;
use Psr\Log\LoggerInterface;

final class S3ExportClient
{
    public function __construct(
        private readonly S3Client $client,
        private readonly LoggerInterface $logger,
        private readonly string $bucket,
        private readonly string $prefix = 'compliance/',
    ) {
    }

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
