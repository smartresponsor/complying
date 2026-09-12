<?php

declare(strict_types=1);
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Complying\Service;

/**
 * Coordinates the compliance pii scrubber responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePiiScrubber
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     *
     * @param array<int,string> $fields
     */
    public function __construct(private readonly array $fields = ['email', 'phone', 'ssn'])
    {
    }

    /**
     * Performs the scrub behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function scrub(array $data): array
    {
        foreach ($this->fields as $f) {
            if (\array_key_exists($f, $data)) {
                $data[$f] = '***';
            }
        }

        return $data;
    }

    /**
     * Performs the scrub json behavior as part of the owning compliance responsibility.
     */
    public function scrubJson(string $json): string
    {
        $data = json_decode($json, true);
        if (!\is_array($data)) {
            return $json;
        }

        return json_encode($this->scrub($data), \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR);
    }
}
