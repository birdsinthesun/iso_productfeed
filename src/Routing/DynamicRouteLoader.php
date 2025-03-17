<?php

namespace Bits\IsoProductfeed\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Bits\IsoProductfeed\Service\ResourceResolver;
use Doctrine\DBAL\Connection;

class DynamicRouteLoader extends Loader
{
    private ResourceResolver $resourceResolver;
    private Connection $db; // Doctrine DBAL Connection

    public function __construct(ResourceResolver $resourceResolver, Connection $db)
    {
        $this->resourceResolver = $resourceResolver;
        $this->db = $db;
    }

    public function load($resource, string $type = null): RouteCollection
    {
        $routes = new RouteCollection();

        // Hole alle Dateinamen aus der Datenbank
        $sql = "SELECT xml_filename FROM tl_iso_productfeed WHERE xml_filename IS NOT NULL AND xml_filename != ''";
        $filenames = $this->db->fetchFirstColumn($sql);

        foreach ($filenames as $fileName) {
            $filePath = $this->resourceResolver->resolveFilePath($fileName);

            $route = new Route(
                '/files/' . $fileName, // Dynamische URL
                [
                    '_controller' => 'Bits\IsoProductfeed\Controller\FeedController::serveXml',
                    'fileName' => $fileName,
                    'filePath' => $filePath,
                ],
                [], // Anforderungen
                [], // Standard-Optionen
                null, // Host
                ['https'], // Schemes
                ['GET'] // HTTP-Methoden
            );

            $routes->add('tl_iso_productfeed_' . $fileName, $route);
        }

        return $routes;
    }

    public function supports($resource, string $type = null): bool
    {
        return 'dynamic' === $type;
    }
}
