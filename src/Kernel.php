<?php

declare(strict_types=1);

namespace App\Complying;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * Boots the standalone Complying application while preserving bundle reuse.
 */
final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Loads standalone service configuration for the selected environment.
     */
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getProjectDir().'/config/services.yaml');
    }

    /**
     * Loads the component route collection for HTTP runtime use.
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getProjectDir().'/config/routes.yaml');
    }
}
