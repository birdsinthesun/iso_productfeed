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
            
            $dc->output .= '<div style="margin:10px; padding:10px; background:#f9f9f9; border:1px solid #ccc;">
                    Die Meta-XML-Datei ist eine Datei, die dabei hilft, Produktdaten zwischen verschiedenen Systemen auszutauschen. Sie sorgt dafür, dass alle wichtigen Informationen zu Ihren Produkten, wie Name, Preis, Verfügbarkeit und Bilder, zentral gespeichert sind und automatisch an andere Plattformen weitergegeben werden können.

Mit der Meta-XML-Datei können Ihre Produkte beispielsweise auf Facebook und Instagram dargestellt werden, ohne dass Sie die Produktdaten doppelt einpflegen müssen. Das spart Zeit, reduziert Fehler und sorgt dafür, dass alle Kanäle stets aktuelle Informationen über Ihre Produkte anzeigen. So bleiben Ihre Angebote überall konsistent und professionell.
                  </div>';
      
        }

    }
}