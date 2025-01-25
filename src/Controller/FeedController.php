<?php

namespace Bits\IsoProductfeed\Controller;

use Symfony\Component\HttpFoundation\Response;

class FeedController
{
    public function serveXml(string $fileName): Response
    {
        $filePath = sprintf('%s/files/%s', $_SERVER['DOCUMENT_ROOT'], $fileName);

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('The file does not exist.');
        }

        $content = file_get_contents($filePath);

        return new Response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
