<?php

namespace Bits\IsoProductfeed\Model;

use Contao\Database;

class Price
{
    private string $productTable = 'tl_iso_product';
    private string $priceTable = 'tl_iso_product_price';
    private string $tierTable = 'tl_iso_product_pricetier';

    /**
     * Finde alle Preis- und Preisstufen-Daten für ein bestimmtes Produkt.
     */
    public function findProductPricesWithTiers(int $productId): array
    {
        $db = Database::getInstance();

        $query = "
            SELECT
                p.*, 
                t.*, 
                prod.id
            FROM
                {$this->productTable} prod
            JOIN
                {$this->priceTable} p
            ON
                prod.id = p.pid
            JOIN
                {$this->tierTable} t
            ON
                p.id = t.pid
            WHERE
                prod.id = ?
        ";

        $result = $db->prepare($query)->execute($productId);

        return $result->fetchAllAssoc();
    }
}
