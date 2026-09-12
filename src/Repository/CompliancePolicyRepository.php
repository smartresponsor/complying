<?php

declare(strict_types=1);

namespace App\Complying\Repository;

/**
 * Provides persistence queries for compliance policy repository records used by compliance workflows.
 */
final class CompliancePolicyRepository
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly string $policyDir)
    {
    }

    /**
     * Performs the load behavior as part of the owning compliance responsibility.
     *
     * @return array<string,mixed> */
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
