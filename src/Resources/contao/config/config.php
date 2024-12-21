<?php
// src/Resources/config/config.php

use Contao\CoreBundle\ContaoCoreBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


$GLOBALS['BE_MOD']['isotope']['iso_productfeed'] = [
    'tables' => ['tl_iso_productfeed'], // Tabelle, die in diesem Modul verwaltet wird
    'icon'   => 'bundles/myextension/icon.svg' // Icon für den Menüpunkt
   // 'callback' => 'Bits\IsoProductfeed\Backend\ConfigModule' // Optionale Callback-Klasse für die Logik
];
return static function (ContainerConfigurator $containerConfigurator) {
$services = $containerConfigurator->services();


$container->loadFromExtension('twig', [
    'paths' => [
        '%kernel.project_dir%/vendor/birdsinthesun/iso_productfeed/contao/templates' => '@Contao_Iso_ProductfeedBundle'
    ]
]);
};
?>