<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

/**
 * Coordinates the compliance dlp redactor responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceDlpRedactor
{
    /**
     * Performs the redact array behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function redactArray(array $data): array
    {
        $out = [];
        foreach ($data as $key => $value) {
            if (\is_string($value)) {
                $out[$key] = $this->redactString($value);
            } elseif (\is_array($value)) {
                $out[$key] = $this->redactArray($value);
            } else {
                $out[$key] = $value;
            }
        }

        return $out;
    }

    /**
     * Performs the redact string behavior as part of the owning compliance responsibility.
     */
    public function redactString(string $input): string
    {
        // email
        $input = preg_replace('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/', '[email_redacted]', $input) ?? $input;
        // phone (simple)
        $input = preg_replace('/\+?\d[\d\s\-]{7,}\d/', '[phone_redacted]', $input) ?? $input;
        // credit card (13-19 digits)
        $input = preg_replace('/\b\d{13,19}\b/', '[card_redacted]', $input) ?? $input;
        // ssn like
        $input = preg_replace('/\b\d{3}-\d{2}-\d{4}\b/', '[ssn_redacted]', $input) ?? $input;

        return $input;
    }
}
