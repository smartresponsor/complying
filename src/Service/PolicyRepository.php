<?php

declare(strict_types=1);

namespace App\Complying\Service;

final class PolicyRepository
{
    public function __construct(private readonly string $policyDir)
    {
    }

    /** @return array<string,mixed> */
    public function load(string $nameEntity = 'default'): array
    {
        $path = rtrim($this->policyDir, \DIRECTORY_SEPARATOR).\DIRECTORY_SEPARATOR.$nameEntity.'.json';
        if (!is_file($path)) {
            throw new \RuntimeException('Policy file not found: '.$path);
        }
        $json = file_get_contents($path);

        return json_decode($json ?: '[]', true) ?: [];
    }
}
