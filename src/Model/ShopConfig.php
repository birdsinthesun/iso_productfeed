<?php

namespace Bits\IsoProductfeed\Model;

use Contao\Model;
use Contao\Database;

class ShopConfig extends Model
{
    // Definiere den Namen der Tabelle, die mit diesem Modell verbunden ist
    protected static $strTable = 'tl_iso_config'; // Ersetze dies durch den tatsächlichen Tabellenname

    /**
     * Findet alle Shop-Konfigurationen aus der Datenbank.
     *
     * @return \Contao\Database\Result|null Das Ergebnis der Datenbankabfrage oder null, wenn keine gefunden wurden
     */
    public static function findShopConfigurations()
    {
        // Verwende Contao's Datenbankabstraktionsschicht, um alle Shop-Konfigurationen zu finden
        $result = Database::getInstance()->prepare("SELECT id,name FROM " . static::$strTable)
                                         ->execute();

        // Array für die Ergebnisse
    $configs = [];

    // Iteriere über das Ergebnis und baue das assoziative Array
    while ($result->next()) {
        // Benutze die ID als Key und den Name als Value
        $configs[$result->id] = $result->name;
    }

    return $configs; // Gibt das Array zurück
    }
}
