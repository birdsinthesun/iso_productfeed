<?php

namespace Bits\IsoProductfeed\Service;

use Contao\PageModel;
use Contao\Environment;
use Contao\Database;
use Contao\System;
use Contao\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Bits\IsoProductfeed\Model\Product;
use Bits\IsoProductfeed\Model\Price;
use Bits\IsoProductfeed\Model\ShopConfig;

class Generator
{
    private array $settings;
    private string $table;
    private array $productfeedConfig;

    public function __construct(array $settings)
    {
        $this->settings = $settings;

        // Setze globale Variablen aus dem übergebenen Array
        if (isset($settings['table'])) {
            $this->table = $settings['table'];
        }

        if (isset($settings['productfeedConfig'])) {
            $this->productfeedConfig = $settings['productfeedConfig'];
        }
    }

    public function getXmlFiles()
    {
        // Überprüfen, ob die notwendigen Einstellungen vorhanden sind
        if (empty($this->table) || empty($this->productfeedConfig)) {
            throw new \InvalidArgumentException('Die notwendigen Einstellungen wurden nicht korrekt übergeben.');
        }

        // open a new File
        $PageModel = PageModel::findById($this->productfeedConfig['link']);
        $PageIsotopeModel = PageModel::findById($this->productfeedConfig['link_isotope']);
        
        $arrTwigMeta = [];
        $arrTwigMeta['title'] = $this->productfeedConfig['title'];
        $arrTwigMeta['link'] = $PageModel->getFrontendUrl();
        //$arrTwigMeta['atom:link'] = xml-file-url
        $arrTwigMeta['description'] = $this->productfeedConfig['description'];
        $arrTwigMeta['language'] = 'de'; // TODO: Shop-Config
        $arrTwigMeta['generate_time'] = date('r');

        // show item Fields for developement
        Controller::loadDataContainer($this->table);
        $itemXmlFields = $GLOBALS['TL_DCA'][$this->table]['fields'];

        // Gefiltertes Array
        $itemXmlFields = array_filter(
            $itemXmlFields,
            static fn($key) => str_starts_with($key, 'g_'),
            ARRAY_FILTER_USE_KEY
        );

        // generate Items of the Xml File 
        $products = new Product();
        $products = $products->findAll();
        $arrTwigItems = [];
        if ($products !== null) {
            $products = array_filter(
                $products,
                static fn($item) => $item['published'] === '1'
            );

            foreach ($products as $product) {
                $arrTwigItems[$product['id']]['g:condition'] = $this->getAvailability(
                    $product[$this->productfeedConfig['g_condition']],
                    $product['id']
                );
                $arrTwigItems[$product['id']]['g:brand'] = $product[$this->productfeedConfig['g_brand']];;
                $arrTwigItems[$product['id']]['g:id'] = $product[$this->productfeedConfig['g_id']];
                $arrTwigItems[$product['id']]['g:title'] = $product[$this->productfeedConfig['g_title']];
                $arrTwigItems[$product['id']]['g:description'] = strip_tags($product[$this->productfeedConfig['g_description']]);
                $arrTwigItems[$product['id']]['g:link'] = $this->generateProductUrl($PageIsotopeModel, $product);
                $arrTwigItems[$product['id']]['g:image_link'] = $this->generateImageSrc(unserialize($product[$this->productfeedConfig['g_image']]));
                $price = new Price();
                $priceTiers = $price->findProductPricesWithTiers($product['id']);
                $arrTwigItems[$product['id']]['g:price'] = $this->getPrice((int)$priceTiers[0]['price']);
                $arrTwigItems[$product['id']]['g:sale_price'] = $this->getPrice((int)$product[$this->productfeedConfig['g_sale_price']]);
                $arrTwigItems[$product['id']]['g:availability'] = $this->getAvailability(
                    $product[$this->productfeedConfig['g_availability']],
                    $product['id']
                );
            }
        }

        // Make Twig Template
        $twig = System::getContainer()->get('twig');
        $xml = $twig->render('@Contao/xml_file.html.twig', [
            'meta' => $arrTwigMeta,
            'products' => $arrTwigItems,
        ]);

        // XML-Datei erstellen und speichern
        $filesystem = new Filesystem();
        $filePath = '../files/' . $this->productfeedConfig['id'] . '_' . $this->generateAlias($this->productfeedConfig['title']) . '.xml';

        try {
            $filesystem->dumpFile($filePath, $xml);
        } catch (IOExceptionInterface $exception) {
            echo "Fehler beim Erstellen der Datei: " . $exception->getPath();
        }
    }

    private function getPrice(int $price)
    {
         $shopConfig = new ShopConfig;
         $shopConfigArr = $shopConfig::findById($this->productfeedConfig['link']);
        // Berechnung der Preislogik
        if ($shopConfigArr['priceCalculateMode'] === 'mul') {
            $price *= $shopConfigArr['priceCalculateFactor'];
        } else {
            $price /= $shopConfigArr['priceCalculateFactor'];
        }

        // TODO: Logik für priceRoundIncrement
        $price = $this->formatNumberWithString(
            $price,
            $shopConfigArr['currency'],
            $shopConfigArr['currencyPosition'] . '_' . $shopConfigArr['currencySpace'],
            $shopConfigArr['currencySymbol'],
            $shopConfigArr
        );

        return $price;
    }

    private function formatNumberWithString($price, $string, $case, $useCurrencySymbol = true, $shopConfig)
    {
        switch ($shopConfig['currencyFormat']) {
            case '10\'000.00':
                $price = number_format($price, $shopConfig['priceRoundPrecision'], '.', '\'');
                break;

            case '10000.00':
                $price = number_format($price, $shopConfig['priceRoundPrecision'], '.', '');
                break;

            case '10,000.00':
                $price = number_format($price, $shopConfig['priceRoundPrecision'], '.', ',');
                break;

            case '10.000,00':
                $price = number_format($price, $shopConfig['priceRoundPrecision'], '.', ',');
                break;

            default:
                $price = number_format($price, $shopConfig['priceRoundPrecision'], '.', ',');
                break;
        }

        $displayString = $useCurrencySymbol ? 'EUR' : $string;

        switch ($case) {
            case 'right_0':
                return "{$price}{$displayString}";
            case 'right_1':
                return "{$price} {$displayString}";
            case 'left_0':
                return "{$displayString}{$price}";
            case 'left_1':
                return "{$displayString} {$price}";
            default:
                return "{$price} {$displayString}";
        }
    }

    private function generateProductUrl($pageModel, $productArr)
    {
        return Environment::get('base') . $pageModel->loadDetails()->alias . '/' . $productArr['alias'] . '.html';
    }

    private function generateImageSrc($imagesArr)
    {
        return Environment::get('base') . 'isotope/' . mb_substr($imagesArr[0]['src'], 0, 1) . '/' . $imagesArr[0]['src'];
    }

    private function getAvailability($optionId, $productId): ?string
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

        return $result->label;
    }
    
    private function getCondition($optionId, $productId): ?string
    {
        $db = Database::getInstance();

        $query = "
            SELECT 
                p.label
            FROM 
                tl_iso_attribute_option p
            INNER JOIN 
                tl_iso_product a ON p.id = a.g_condition
            WHERE 
                p.id = ? AND a.id = ?
        ";

        $result = $db->prepare($query)
            ->execute($optionId, $productId);

        if ($result->numRows < 1) {
            return null;
        }

        return $result->label;
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
