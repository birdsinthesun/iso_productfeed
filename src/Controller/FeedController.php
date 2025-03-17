<?php

namespace Bits\IsoProductfeed\Controller;

use Symfony\Component\HttpFoundation\Response;

class FeedController
{
    public function serveXml(string $fileName,string $filePath): Response
    {
        
      
        if (!file_exists($filePath)) {
            echo '<p>The file does not exist.</p>';
        }

        $content = file_get_contents($filePath);

        return new Response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
