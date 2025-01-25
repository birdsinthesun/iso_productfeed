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
        
        var_dump('DynamicRouteLoader: load called');
        $routes = new RouteCollection();

        // Hole den Dateinamen aus dem Resolver oder verwende den Standardnamen
        $fileName = $this->resourceResolver->getFileName() ?? $this->defaultFileName;

        // Berechne den vollständigen Pfad
        $filePath = $this->resourceResolver->resolveFilePath($fileName);

        $routes->add('serve_xml', new Route(
            '/xml', // Die URL der Route
            [
                '_controller' => 'Bits\IsoProductfeed\Controller\FeedController::serveXml',
                'filePath' => $filePath,
            ]
        ));

        return $routes;
    }

    public function supports($resource, string $type = null): bool
    {
        var_dump('DynamicRouteLoader: supports called with type: ' . $type);
        return 'dynamic' === $type;
    }
}
