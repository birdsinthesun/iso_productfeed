<?php
namespace Bits\IsoProductfeed\Backend;

use Contao\Backend as Backend;
use Contao\System;

class ConfigModule extends Backend
{
    public function __construct()
    {
        parent::__construct();
        // Hier kannst du deine Logik hinzufügen
    }

    public function generate():string
    {
        // Logik für das Backend-Modul
        return 'hello world 1';
    }
    public function run():string
    {
        // Logik für das Backend-Modul
        return 'hello world 1';
    }
}