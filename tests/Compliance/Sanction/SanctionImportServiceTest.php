<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Sanction;

use App\Complying\Service\SanctionImportService;
use PHPUnit\Framework\TestCase;

final class SanctionImportServiceTest extends TestCase
{
    public function testImportReturnsInt(): void
    {
        $em = $this->createMock(\Doctrine\ORM\EntityManagerInterface::class);
        $repo = $this->createMock(\App\Complying\RepositoryInterface\SanctionListEntryRepositoryInterface::class);
        $repo->method('existsByName')->willReturn(false);

        $service = new SanctionImportService($em, $repo);
        $count = $service->import([['nameEntity' => 'John Doe', 'source' => 'test']]);

        $this->assertSame(1, $count);
    }
}
