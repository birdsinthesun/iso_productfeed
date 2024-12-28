<?php

namespace Bits\IsoProductfeed\Model;

use Contao\Model;
use Contao\Database;

class ShopConfig
{
    // Definiere den Namen der Tabelle, die mit diesem Modell verbunden ist
    protected static $table = 'tl_iso_config'; // Ersetze dies durch den tatsächlichen Tabellenname
    protected static $arrData = [];

    /**
     * Findet alle Shop-Konfigurationen aus der Datenbank.
     *
     * @return array|null Ein assoziatives Array mit den Shop-Konfigurationen oder null, wenn keine gefunden wurden
     */
    public static function findShopConfigurations()
    {
        // Verwende Contao's Datenbankabstraktionsschicht, um alle Shop-Konfigurationen zu finden
        $result = Database::getInstance()->prepare("SELECT id,name FROM " . static::$table)
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

    /**
     * Findet alle Shop-Konfigurationen aus der Datenbank.
     *
     * @return array|null Das Ergebnis der Datenbankabfrage oder null, wenn keine gefunden wurden
     */
    public static function findAll(): ?array
    {
        // Verwende Contao's Datenbankabstraktionsschicht, um alle Konfigurationseinträge zu finden
        $result = Database::getInstance()->prepare("SELECT * FROM " . static::$table)
                                         ->execute();

        // Array für die Ergebnisse
        $configs = [];

        // Iteriere über das Ergebnis und baue das assoziative Array
        while ($result->next()) {
            // Benutze die ID als Key und den gesamten Eintrag als Wert
            $configs[$result->id] = $result->fetchAssoc(); // Speichert alle Daten als assoziatives Array
        }

        return !empty($configs) ? $configs : null; // Gibt das Array zurück oder null, wenn keine Einträge gefunden wurden
    }

    /**
     * Findet eine Shop-Konfiguration basierend auf ihrer ID.
     *
     * @param int $id Die ID der Shop-Konfiguration
     * @return array|null Die Daten der Shop-Konfiguration oder null, wenn keine gefunden wurde
     */
    public static function findById(int $id): ?array
    {
        $db = Database::getInstance();
        $result = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ?")
                     ->execute($id);
        static::$arrData = $result->numRows ? $result->fetchAssoc() : null;
        return static::$arrData;
    }
}
