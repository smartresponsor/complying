<?php

declare(strict_types=1);

namespace App\Complying;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Boots the standalone Complying application while preserving bundle reuse.
 */
final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Loads standalone service configuration for the selected environment.
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir().'/config/services.yaml');
    }

    /**
     * Loads the component route collection for HTTP runtime use.
     */
    protected function configureRoutes(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir().'/config/routes.yaml');
    }
}
