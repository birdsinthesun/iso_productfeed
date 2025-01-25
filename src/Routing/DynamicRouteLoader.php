<?php

namespace Bits\IsoProductfeed\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Bits\IsoProductfeed\Service\ResourceResolver;

class DynamicRouteLoader extends Loader
{
    private ResourceResolver $resourceResolver;
    private string $defaultFileName;

    public function __construct(ResourceResolver $resourceResolver, string $defaultFileName)
    {
        $this->resourceResolver = $resourceResolver;
        $this->defaultFileName = $defaultFileName;
    }

    public function load($resource, string $type = null): RouteCollection
    {
       
        $routes = new RouteCollection();

        // Hole den Dateinamen aus dem Resolver oder verwende den Standardnamen
        $fileName = $this->resourceResolver->getFileName() ?? $this->defaultFileName;

        // Berechne den vollständigen Pfad
        $filePath = $this->resourceResolver->resolveFilePath($fileName);
        $routes->add($fileName, new Route(
            '/files/'.$fileName, // Die URL der Route
            [
                '_controller' => 'Bits\IsoProductfeed\Controller\FeedController::serveXml',
                'fileName' => $fileName,
                'filePath' => $filePath,
            ],
            [], // Anforderungen (z. B. Constraints für Parameter)
        [], // Standard-Optionen
        'shop.bits-design.de', // Host (wird unten gesetzt)
        ['https'], // Schemes (z. B. 'https' oder 'http')
        ['GET'] // HTTP-Methoden
        ));

        return $routes;
    }

    public function supports($resource, string $type = null): bool
    {
        return 'dynamic' === $type;
    }
}
