<?php
namespace Bits\IsoProductfeed\EventListener\DataContainer;

use Contao\DataContainer;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;


class IsoProductfeedCallbackListener
{
    
    #[AsCallback(table: 'tl_iso_productfeed', target: 'config.onload', priority: 4000)]
    public function __invoke(DataContainer $dc): void
    {
            $dc->output .= '<div style="margin:10px; padding:10px; background:#f9f9f9; border:1px solid #ccc;">
                    Die Meta-XML-Datei ist eine Datei, die dabei hilft, Produktdaten zwischen verschiedenen Systemen auszutauschen. Sie sorgt dafür, dass alle wichtigen Informationen zu Ihren Produkten, wie Name, Preis, Verfügbarkeit und Bilder, zentral gespeichert sind und automatisch an andere Plattformen weitergegeben werden können.

Mit der Meta-XML-Datei können Ihre Produkte beispielsweise auf Facebook und Instagram dargestellt werden, ohne dass Sie die Produktdaten doppelt einpflegen müssen. Das spart Zeit, reduziert Fehler und sorgt dafür, dass alle Kanäle stets aktuelle Informationen über Ihre Produkte anzeigen. So bleiben Ihre Angebote überall konsistent und professionell.
                  </div>';
                  
      
        }

    
}