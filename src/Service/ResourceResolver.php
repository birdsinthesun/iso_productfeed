<?php

namespace Bits\IsoProductfeed\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class ResourceResolver
{
    private string $baseDirectory;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->baseDirectory = rtrim($parameterBag->get('kernel.project_dir').'/files', '/');
    }

    public function resolveFilePath(string $fileName): string
    {
        return $this->baseDirectory . '/' . ltrim($fileName, '/');
    }

    public function getFileName(): ?string
    {
        // Dynamisch den Dateinamen bestimmen (z. B. durch Datenbankabfrage oder API-Aufruf)
        // Hier ein einfaches Beispiel:
        $files = glob($this->baseDirectory . '/*.xml');
        return $files ? basename(reset($files)) : ''; // Nimmt die erste gefundene XML-Datei
    }
}
