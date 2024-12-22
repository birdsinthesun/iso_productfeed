<?php

namespace Bits\IsoProductfeed;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    
    
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/'.$this->environment.'/*.yaml');

        // Registriere deinen benutzerdefinierten Pfad
       // $container->import('Resources/config/packages/twig.yaml');
         if (file_exists('../Resources/contao/config/twig.yaml')) {
        echo "twig.yaml exists";
    } else {
        echo "twig.yaml not found";
    }
    exit; 
    }
}