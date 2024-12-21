<?php
namespace Bits\IsoProductfeed\Backend;

use Contao\DataContainer;
use Contao\System;
use Contao\CoreBundle\Framework\ContaoFramework as Framework;

class AboutOnloadCallback
{
    
    private $framework;
    
      public function __construct(Framework $framework)
    {
        $this->framework = $framework;
    }
    
    public function getInfo(DataContainer $dc): void
    {
        
        $this->framework->initialize();
        // Prüfen, ob der Aufruf im Backend erfolgt
        if (System::getContainer()->get('contao.framework')->isBackend()) {   
        
            $container = System::getContainer();

            // Verfügbarkeit des Services prüfen
            if (!$container->has('Bits\IsoProductfeed\Backend\AboutOnloadCallback')) {
                throw new \RuntimeException('Service "Bits\IsoProductfeed\Backend\AboutOnloadCallback" is not available.');
            }

            $aboutService = $container->get('Bits\IsoProductfeed\Backend\AboutOnloadCallback');
        
      
        }

    }
}