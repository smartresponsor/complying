<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\E2E;

use PHPUnit\Framework\TestCase;

final class E2EScriptsExistTest extends TestCase
{
    public function testExists(): void
    {
        $this->assertTrue(file_exists(__DIR__.'/../../../../tools/e2e/deny.php'));
        $this->assertTrue(file_exists(__DIR__.'/../../../../tools/e2e/review.php'));
        $this->assertTrue(file_exists(__DIR__.'/../../../../tools/e2e/permit.php'));
    }
}
