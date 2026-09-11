<?php

declare(strict_types=1);

namespace App\Complying\ServiceInterface;

interface SanctionImportServiceInterface
{
    /**
     * @param array<int, array{name: string, source?: string}> $entries
     *
     * @return int imported count
     */
    public function import(array $entries): int;
}
