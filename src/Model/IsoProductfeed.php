<?php

namespace Bits\IsoProductfeed\Model;

use Contao\Database;

class IsoProductfeed
{
    // Definiere den Namen der Tabelle, die mit diesem Modell verbunden ist
    protected static $table = 'tl_iso_productfeed'; // Ersetze dies durch den tatsächlichen Tabellenname

    /**
     * Findet alle Produktfeeds aus der Datenbank.
     *
     * @return array|null Ein assoziatives Array mit den Produktfeed-Daten oder null, wenn keine gefunden wurden
     */
    public static function findAll(): ?array
    {
        // Verwende Contao's Datenbankabstraktionsschicht, um alle Produktfeeds zu finden
        $result = Database::getInstance()->prepare("SELECT * FROM " . static::$table)
                                         ->execute();

        // Array für die Ergebnisse
        $productfeeds = [];

        // Iteriere über das Ergebnis und baue das assoziative Array
        while ($result->next()) {
            // Benutze die ID als Key und den gesamten Eintrag als Wert
            $productfeeds[$result->id] = $result->row(); // Speichert alle Daten als assoziatives Array
        }

        return !empty($productfeeds) ? $productfeeds : null; // Gibt das Array zurück oder null, wenn keine Einträge gefunden wurden
    }

    /**
     * Findet einen Produktfeed basierend auf seiner ID.
     *
     * @param int $id Die ID des Produktfeeds
     * @return array|null Die Daten des Produktfeeds oder null, wenn keiner gefunden wurde
     */
    public static function findById(int $id): ?array
    {
        $db = Database::getInstance();
        $result = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ?")
                     ->execute($id);
        return $result->numRows ? $result->fetchAssoc() : null;
    }
}
