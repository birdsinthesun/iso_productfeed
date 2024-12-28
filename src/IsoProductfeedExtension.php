<?php

namespace Bits\IsoProductfeed;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Extension\Extension;

class IsoProductfeedExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->register('app.form_factory', FormFactoryInterface::class)
            ->setAlias(FormFactoryInterface::class, 'form.factory')
            ->setPublic(true);
    }
}
