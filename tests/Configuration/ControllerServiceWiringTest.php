<?php

declare(strict_types=1);

namespace App\Complying\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

final class ControllerServiceWiringTest extends TestCase
{
    public function testControllerServicesDiscoverTheCanonicalControllerDirectory(): void
    {
        $configuration = Yaml::parseFile(__DIR__.'/../../config/compliance_services_autowire.yaml');
        $controllerServices = $configuration['services']['App\\Complying\\Controller\\'] ?? null;

        self::assertIsArray($controllerServices);
        self::assertSame('../src/Controller/', $controllerServices['resource'] ?? null);
        self::assertDirectoryExists(__DIR__.'/../../src/Controller');
    }
}
