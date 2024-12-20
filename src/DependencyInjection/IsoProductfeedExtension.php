<?php

namespace Bits\IsoProductfeed\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Bits\IsoProductfeed\DependencyInjection\Configuration as IsoProductfeedConfiguration;

class IsoProductfeedExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Lade Service-Definitionen aus einer services.yaml-Datei
        $loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader(
            $container,
            new \Symfony\Component\Config\FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yaml');
    }
    
     public function getConfiguration(array $configs, ContainerBuilder $container): ?ConfigurationInterface
    {
        return new IsoProductfeedConfiguration();
    }
}
