<?php

namespace Bits\IsoProductfeed\Service;

class ResourceResolver
{
    private string $baseDirectory;

    public function __construct(string $baseDirectory)
    {
        $this->baseDirectory = rtrim($baseDirectory, '/');
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
        return $files ? basename(reset($files)) : null; // Nimmt die erste gefundene XML-Datei
    }
}
