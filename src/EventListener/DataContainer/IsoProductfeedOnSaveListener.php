<?php
namespace Bits\IsoProductfeed\EventListener\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Contao\PageModel;
use Contao\Environment;
use Contao\Database;
use Contao\System;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Bits\IsoProductfeed\Model\Product;
use Bits\IsoProductfeed\Model\Price;
use Bits\IsoProductfeed\Model\ShopConfig;

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
       
        $this->getXmlData($dc);
        
    }
    
    private function getXmlData($dc){
        
        $table = $dc->table;
        
        //open a new File

        //generate Metadata of the Xml File
        $PageModel = PageModel::findByPk($dc->activeRecord->link);
        $arrTwigMeta = [];
        $arrTwigMeta['tilte'] = $dc->activeRecord->title;
        $arrTwigMeta['link'] = $PageModel->getFrontendUrl();
        $arrTwigMeta['description'] = $dc->activeRecord->description;
        $arrTwigMeta['language'] = 'de'; //ToDO Shop-Config
        $arrTwigMeta['generate_time'] = date('r');
        
        // show item Fields
        $itemXmlFields = $GLOBALS['TL_DCA'][$table]['fields'];

        // Gefiltertes Array
        $itemXmlFields = array_filter(
            $itemXmlFields,
            static fn($key) => str_starts_with($key, 'g_'),
            ARRAY_FILTER_USE_KEY
        );

         //generate Items of the Xml File 
         $products = new Product();
         $products = $products->findAll();
         $arrTwigItems = [];
        if ($products !== null) {
               
                
                $products = array_filter(
                        $products,
                            static fn($item) => $item['published'] === '1'
                   
                );

 
                foreach ($products as $product) {
                    
                    $arrTwigItems[$product['id']]['g:id'] = $product[$dc->activeRecord->g_id];
                    $arrTwigItems[$product['id']]['g_tilte'] = $product[$dc->activeRecord->g_title];
                    $arrTwigItems[$product['id']]['g:description'] = $product[$dc->activeRecord->g_description];
                    $arrTwigItems[$product['id']]['g:link'] = $this->generateProductUrl($PageModel, $product);
                    $arrTwigItems[$product['id']]['g:image'] = $this->generateImageSrc(unserialize($product[$dc->activeRecord->g_image]));
                    $price = new Price();
                    $priceTiers = $price->findProductPricesWithTiers($product['id']);
                    $arrTwigItems[$product['id']]['g_price'] = $this->getPrice($dc,(int)$priceTiers[0]['price']);
                    $arrTwigItems[$product['id']]['g:sale_price'] = $this->getPrice($dc,(int)$product[$dc->activeRecord->g_sale_price]);
                    $arrTwigItems[$product['id']]['g:availability'] = $this->getAvailability($product[$dc->activeRecord->g_availability],$product['id']);
     
                }

            } 
            
            //Make Twig Template
            $twig = System::getContainer()->get('twig'); 
            $xml = $twig->render('@Contao/xml_file.html.twig', 
            [       'meta' => $arrTwigMeta,
                    'products' => $arrTwigItems
            ]);
            
            // XML-Datei erstellen und speichern
           

            $filesystem = new Filesystem();

            $filePath = '../files/'. $dc->activeRecord->id.'_'.$this->generateAlias($dc->activeRecord->title).'.xml';
            var_dump($filePath);
            try {
                // Datei erstellen und schreiben
                $filesystem->dumpFile($filePath, $xml);
                echo "Datei wurde erfolgreich erstellt.";exit;
            } catch (IOExceptionInterface $exception) {
                echo "Fehler beim Erstellen der Datei: " . $exception->getPath();exit;
            }
        }
        
        private function getPrice($dc,int $price){
            
            
            $shopConfig = new ShopConfig;
            $shopConfigArr = $shopConfig::findById($dc->activeRecord->link);
            
            //Berechnung
            if($shopConfigArr['priceCalculateMode']==='mul'){
                $price = $price * $shopConfigArr['priceCalculateFactor'];
            }else{
                $price = $price / $shopConfigArr['priceCalculateFactor'];
            } 
            // TODos  Logik für $shopConfigArr['priceRoundIncrement'];
            // Formatierung der Währung -> CurrencySymbol aus dem GlobalArray holen
            $price =  $this->formatNumberWithString($price,$shopConfigArr['currency'], $shopConfigArr['currencyPosition'].'_'.$shopConfigArr['currencySpace'], $shopConfigArr['currencySymbol'],$shopConfigArr);


            return $price;
        }
        
        
        private function formatNumberWithString($price, $string, $case, $useCurrencySymbol = true, $shopConfigArr) {
                 // Formatierung der Zahl
                switch ($shopConfigArr['currencyFormat']) {
                    case '10\'000.00':
                        $price = number_format($price, $shopConfigArr['priceRoundPrecision'], '.', '\'');
                        break;

                    case '10000.00':
                        $price = number_format($price, $shopConfigArr['priceRoundPrecision'], '.', '');
                        break;

                    case '10,000.00':
                        $price = number_format($price, $shopConfigArr['priceRoundPrecision'], '.', ',');
                        break;
                        
                    case '10.000,00':
                        $price = number_format($price, $shopConfigArr['priceRoundPrecision'], ',', '.');
                        break;

                    default:
                        $price = number_format($price, $shopConfigArr['priceRoundPrecision'], ',', '.');
                        break;
                }
            

                $displayString = $useCurrencySymbol ? '€' : $string;

                switch ($case) {
                    case 'right_0': // Zahl links, kein Leerzeichen
                        return "{$price}{$displayString}";

                    case 'right_1': // Zahl links, mit Leerzeichen
                        return "{$price} {$displayString}";

                    case 'left_0': // String links, kein Leerzeichen
                        return "{$displayString}{$price}";

                    case 'left_1': // String links, mit Leerzeichen
                        return "{$displayString} {$price}";

                    default: // Fallback, wenn keine gültige Option angegeben wurde
                        return "{$price} {$displayString}";
                }
            }
            
        private function generateProductUrl($pageModel, $productArr){
        
        
            return Environment::get('base').$pageModel->loadDetails()->alias.'/'.$productArr['alias'].'.html';
       
        }
        
        private function generateImageSrc($imagesArr){
        
       
          return Environment::get('base').'isotope/'. mb_substr($imagesArr[0]['src'], 0, 1).'/'.$imagesArr[0]['src'];
       
            
        }
        private function getAvailability($optionId,$productId): ?string
        {
           
            $db = Database::getInstance();

            $query = "
                SELECT 
                    p.label
                FROM 
                    tl_iso_attribute_option p
                INNER JOIN 
                    tl_iso_product a ON p.id = a.availability
                WHERE 
                    p.id = ? AND a.id = ?
            ";

            $result = $db->prepare($query)
                         ->execute($optionId, $productId);

            if ($result->numRows < 1) {
                return null; 
            }

            return  $result->label;
        }

        private function generateAlias(string $input): string
        {
            // Entfernt HTML-Tags
            $alias = strip_tags($input);

            // Ersetzt Umlaute und Sonderzeichen
            $transliteration = [
                'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
                'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
            ];
            $alias = strtr($alias, $transliteration);

            // Ersetzt alle nicht-alphanumerischen Zeichen (außer Bindestriche) durch Bindestriche
            $alias = preg_replace('/[^a-zA-Z0-9\-]+/', '-', $alias);

            // Entfernt führende und nachfolgende Bindestriche
            $alias = trim($alias, '-');

            // Wandelt den Alias in Kleinbuchstaben um
            $alias = strtolower($alias);

            return $alias;
        }


}