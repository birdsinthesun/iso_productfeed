<?php

namespace Bits\IsoProductfeed\Contao;

use Contao\DC_Table;
use Contao\System;
use Twig\Environment;

class DC_IsoProductfeed extends DC_Table
{
    
    protected $strTable = 'tl_iso_productfeed';
    
    public function __construct($strTable)
    {
        parent::__construct($strTable);
    }
    
    public function showAll()
    {
        
        $twig = System::getContainer()->get('twig'); // Twig-Umgebung abrufen

        $templateData = [
            'headline' => 'Willkommen im IsoProductfeed-Modul!',
            'message' => 'Hier können Sie Produktfeeds verwalten und konfigurieren.',
        ];
        

//$this->checkTemplate($twig);exit;
        $html = $twig->render('@BitsIsoProductfeed/iso_productfeed_panel.html.twig', $templateData);


        return $html . parent::showAll(); // Das Original-Rendering bleibt erhalten
    }
    
    
    public function checkTemplate(Environment $twig)
    {
        $template = '@BitsIsoProductfeed/iso_productfeed_panel.html.twig';

        if ($twig->getLoader()->exists($template)) {
            echo "Template $template gefunden.";
        } else {
            echo "Template $template nicht gefunden.";
        }
    }
}
