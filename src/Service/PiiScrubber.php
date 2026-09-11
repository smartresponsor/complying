<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

final class PiiScrubber
{
    /**
     * @param array<int,string> $fields
     */
    public function __construct(private readonly array $fields = ['email', 'phone', 'ssn'])
    {
    }

    public function scrub(array $data): array
    {
        foreach ($this->fields as $f) {
            if (\array_key_exists($f, $data)) {
                $data[$f] = '***';
            }
        }

        return $data;
    }

    public function scrubJson(string $json): string
    {
        $data = json_decode($json, true);
        if (!\is_array($data)) {
            return $json;
        }

        return json_encode($this->scrub($data), \JSON_UNESCAPED_UNICODE);
    }
}
