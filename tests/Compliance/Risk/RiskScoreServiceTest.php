<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Risk;

use App\Complying\Service\RiskScoreService;
use PHPUnit\Framework\TestCase;

final class RiskScoreServiceTest extends TestCase
{
    public function testSanctionGivesHighScore(): void
    {
        $svc = new RiskScoreService();
        $dto = $svc->calculate(['is_sanctioned' => true]);
        $this->assertGreaterThanOrEqual(90, $dto->score);
    }
}
