<?php

namespace Bits\IsoProductfeed\Model;

use Contao\Model;
use Contao\Database;

class Attribute extends Model
{
    // Definiere den Namen der Tabelle, die mit diesem Modell verbunden ist
    protected static $strTable = 'tl_iso_attribute'; // Ersetze dies durch den tatsächlichen Tabellenname

    /**
     * Findet alle Shop-Konfigurationen aus der Datenbank.
     *
     * @return \Contao\Database\Result|null Das Ergebnis der Datenbankabfrage oder null, wenn keine gefunden wurden
     */
    public static function getOptions()
    {
        // Verwende Contao's Datenbankabstraktionsschicht, um alle Shop-Konfigurationen zu finden
        $result = Database::getInstance()->prepare("SELECT field_name,name FROM " . static::$strTable)
                                         ->execute();

        // Array für die Ergebnisse
    $configs = [];
    \Contao\System::loadLanguageFile('tl_iso_productfeed');
    \Contao\Controller::loadDataContainer('tl_iso_producttype');
    foreach($GLOBALS['TL_DCA']['tl_iso_producttype']['fields']['attributes']['default'] as $col){
        $configs[$col['name']] = $GLOBALS['TL_LANG']['tl_iso_productfeed']['attributes'][$col['name']];
        
        }

    // Iteriere über das Ergebnis und baue das assoziative Array
    while ($result->next()) {
        // Benutze die ID als Key und den Name als Value
        $configs[$result->field_name] = $result->name;
    }
         $configs['id'] = 'id';
    return $configs; // Gibt das Array zurück
    }
}
