<?php

namespace Bits\IsoProductfeed\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\BackendModuleExecuteEvent;
use Contao\BackendModule;
use Contao\BackendTemplate;
use Symfony\Component\HttpFoundation\Response;

class IsoProductfeedListener extends BackendModule
{
    protected $strTemplate = 'mod_iso_productfeed';

    #[AsCallback(table: 'tl_iso_productfeed', target: 'contao.backend_module_execute', priority: 100)]
    public function generate(): void
    {
        // Hier kannst du benutzerdefinierte Logik implementieren
        // In der Regel wird hier der Inhalt des Moduls zusammengestellt.
        $this->Template->about = '<p>Hier können Sie weitere Inhalte für das Modul definieren.</p>';
        
    }
    /**
	 * Compile the current element
	 */
	protected function compile(){}
}
