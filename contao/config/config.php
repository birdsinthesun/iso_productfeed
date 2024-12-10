<?php
// src/Resources/config/config.php

use Contao\CoreBundle\ContaoCoreBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
$services = $containerConfigurator->services();
};

$container->loadFromExtension('twig', [
    'paths' => [
        '%kernel.project_dir%/vendor/birdsinthesun/themply/contao/templates' => '@Contao_ThemplyBundle'
    ]
]);

?>