<?php
// src/Resources/config/config.php

use Contao\CoreBundle\ContaoCoreBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Form\FormFactoryInterface;



$GLOBALS['BE_MOD']['isotope']['iso_productfeed'] = [
    'tables' => ['tl_iso_productfeed'], // Tabelle, die in diesem Modul verwaltet wird
    'icon'   => 'bundles/myextension/icon.svg', // Icon für den Menüpunkt
   // 'callback' => 'Bits\IsoProductfeed\Contao\DC_IsoProductfeed' // Optionale Callback-Klasse für die Logik
];



return [
    FrameworkBundle::class => ['all' => true],
    ContaoCoreBundle::class => ['all' => true],
    FormFactoryInterface::class => ['all' => true],
   
];
?>