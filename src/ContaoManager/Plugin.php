<?php

namespace Bits\IsoProductfeed\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use Bits\IsoProductfeed\IsoProductfeedBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\RoutingBundle\RoutingBundle;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    /**
     * Registers the IsoProductfeedBundle and specifies dependencies.
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(IsoProductfeedBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, 'isotope','isotope_rules','isotope_reports',TwigBundle::class,FrameworkBundle::class,RoutingBundle::class]), // Load after Contao Core and Isotope
        ];
    }

    /**
     * Loads the route collection for the bundle.
     */
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__ . '/../Resources/config/routes.yaml', 'yaml')
            ->load(__DIR__ . '/../Resources/config/routes.yaml');
    }
}
