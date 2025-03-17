<?php
namespace Bits\IsoProductfeed\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_iso_productfeed', target: 'fields.xml_filename.save')]
class IsoProductfeedXmlFilenameSaveCallback
{
    public function __invoke($value, DataContainer $dc)
    {
        
        $value = $this->generateAlias($dc->activeRecord->id.'_'.$dc->activeRecord->title);

        return $value;
    }
    
    private function generateAlias(string $input): string
    {
        $alias = strip_tags($input);

        $transliteration = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
            'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
        ];
        $alias = strtr($alias, $transliteration);

        $alias = preg_replace('/[^a-zA-Z0-9\-]+/', '-', $alias);
        $alias = trim($alias, '-');
        return strtolower($alias);
    }
}