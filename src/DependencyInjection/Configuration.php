<?php

namespace Bits\IsoProductfeed\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('iso_productfeed');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('isotope')->defaultValue('iso_productfeed')->end()
            ->end();

        return $treeBuilder;
    }
}
