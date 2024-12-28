<?php
namespace Bits\IsoProductfeed\EventListener\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Bits\IsoProductfeed\Service\Generator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;


#[AsCallback(table: 'tl_iso_productfeed', target: 'config.onsubmit', priority: '400')]
class IsoProductfeedOnSaveListener
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    public function __invoke(DataContainer $dc): void
    {
       
        
        $settings = [
            'table' => $dc->table,
            'productfeedConfig' => [
                'id' => $dc->activeRecord->id,
                'link' => $dc->activeRecord->link,
                'title' => $dc->activeRecord->title,
                'description' => $dc->activeRecord->description,
                'g_id' => $dc->activeRecord->g_id,
                'g_title' => $dc->activeRecord->g_title,
                'g_description' => $dc->activeRecord->g_description,
                'g_image' => $dc->activeRecord->g_image,
                'g_sale_price' => $dc->activeRecord->g_sale_price,
                'g_availability' => $dc->activeRecord->g_availability,
            ],
        ];
        $generator = new Generator($settings);
        $generator->getXmlFiles();
        
    }
    
    


}