<?php
// src/ContaoManager/Plugin.php
namespace Bits\Iso_Productfeed\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use Bits\Themply\Iso_ProductfeedBundle;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfonycasts\SassBundle\SymfonycastsSassBundle;

class Plugin implements BundlePluginInterface,RoutingPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(IsotopeBundle::class),
            BundleConfig::create(Iso_ProductfeedBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
               
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__.'/../Controller', 'attribute')
            ->load(__DIR__.'/../Controller')
        ;
    }
}
