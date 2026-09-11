<?php

declare(strict_types=1);

use App\Complying\Service\RiskEngine;
use PHPUnit\Framework\TestCase;

final class RiskEngineSmokeTest extends TestCase
{
    public function testClassIsInstantiable(): void
    {
        $this->assertTrue((new ReflectionClass(RiskEngine::class))->isInstantiable());
    }
}
