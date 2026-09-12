<?php

declare(strict_types=1);

namespace App\Complying\RepositoryInterface;

interface SanctionListEntryRepositoryInterface
{
    public function existsByName(string $nameEntity): bool;
}
