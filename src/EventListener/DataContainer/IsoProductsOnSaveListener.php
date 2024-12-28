<?php
namespace Bits\IsoProductfeed\EventListener\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Bits\IsoProductfeed\Service\Generator;
use Bits\IsoProductfeed\Model\IsoProductfeed;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;


#[AsCallback(table: 'tl_iso_product', target: 'config.onsubmit', priority: '400')]
class IsoProductsOnSaveListener
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    public function __invoke(DataContainer $dc): void
    {
       
        $isoProductfeed = new IsoProductfeed;
        $productfeedConfigs = $isoProductfeed::findAll();
        
        foreach($productfeedConfigs as $id => $productfeedConfig){
            
                $settings = [
                'table' => 'tl_iso_productfeed',
                'productfeedConfig' => [
                    'id' => $id,
                    'link' => $productfeedConfig['link'],
                    'title' => $productfeedConfig['title'],
                    'description' => $productfeedConfig['description'],
                    'g_id' => $productfeedConfig['g_id'],
                    'g_title' =>$productfeedConfig['g_title'],
                    'g_description' => $productfeedConfig['g_description'],
                    'g_image' => $productfeedConfig['g_image'],
                    'g_sale_price' => $productfeedConfig['g_sale_price'],
                    'g_availability' => $productfeedConfig['g_availability'],
                ],
            ];
            $generator = new Generator($settings);
            $generator->getXmlFiles();
        
        }
        
        
    }
    
    


}