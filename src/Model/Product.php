<?php

namespace Bits\IsoProductfeed\Model;

use Contao\Database;

class Product
{
    private string $table = 'tl_iso_product'; // Tabelle der Produktdaten

    public function findAll(): array
    {
        $db = Database::getInstance();
        $result = $db->prepare("SELECT * FROM {$this->table}")->execute();

        return $result->fetchAllAssoc();
    }

    public function findById(int $id): ?array
    {
        $db = Database::getInstance();
        $result = $db->prepare("SELECT * FROM {$this->table} WHERE id = ?")
                     ->execute($id);

        return $result->numRows ? $result->fetchAssoc() : null;
    }

    public function findBy(array $criteria): array
    {
        $db = Database::getInstance();

        $query = "SELECT * FROM {$this->table} WHERE ";
        $conditions = [];
        $values = [];

        foreach ($criteria as $key => $value) {
            $conditions[] = "{$key} = ?";
            $values[] = $value;
        }

        $query .= implode(' AND ', $conditions);
        $result = $db->prepare($query)->execute(...$values);

        return $result->fetchAllAssoc();
    }
}
