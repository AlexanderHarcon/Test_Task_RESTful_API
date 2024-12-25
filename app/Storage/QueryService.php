<?php

namespace App\Storage;


class QueryService
{
    private const TABLE_NAME = 'products';

    private \PDO $pdo;

    public function __construct()
    {
        $db        = new Database();
        $this->pdo = $db->getConnection(); //Create connection to DB
    }

    /**
     * Method allows to find item in DB
     *
     **/
    public function findItem(?string $title, ?int $quantity, float|int|null $price, ?int $limit): array
    {
        $query = 'SELECT title, quantity, price FROM ' . self::TABLE_NAME;

        $params     = [];
        $conditions = [];
        if (!is_null($title)) {
            $conditions[]    = 'title = :title';
            $params['title'] = $title;
        }

        if (!is_null($quantity)) {
            $conditions[]       = 'quantity = :quantity';
            $params['quantity'] = $quantity;
        }

        if (!is_null($price)) {
            $conditions[]    = 'price = :price';
            $params['price'] = $price;
        }

        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        if (!is_null($limit)) {
            $query .= ' LIMIT ' . $limit;
        }

        // Request execution
        $stmt = $this->pdo->prepare($query);
        // Data output
        $stmt->execute($params);
        $row = $stmt->fetchAll($this->pdo::FETCH_ASSOC);

        return $row;
    }

    /**
     * Method allows to add item in DB
     *
     **/
    public function addItem(string $title, int $quantity, int $price): bool
    {
        $query  = 'INSERT INTO ' . self::TABLE_NAME . ' (title, quantity, price) VALUES (:title, :quantity, :price)';
        $params = [
            'title' => $title,
            'quantity' => $quantity,
            'price' => $price,
        ];
        $stmt   = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Method allows to delete item from DB
     *
     **/
    public function deleteItem(string $title): void
    {
        $query = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE title = :title';
        $stmt  = $this->pdo->prepare($query);
        $stmt->execute(['title' => $title]);
    }

    /**
     * Method allows to update item in DB
     *
     **/
    public function updateItem(string $oldTitle, ?string $newTitle = null, ?int $quantity = null, ?float $price = null): bool
    {
        $query       = 'UPDATE ' . self::TABLE_NAME . ' SET ';
        $updateParts = [];
        $params      = ['oldTitle' => $oldTitle];

        if (!is_null($newTitle)) {
            $updateParts[]      = 'title = :newTitle';
            $params['newTitle'] = $newTitle;
        }
        if (!is_null($quantity)) {
            $updateParts[]      = 'quantity = :quantity';
            $params['quantity'] = $quantity;
        }
        if (!is_null($price)) {
            $updateParts[]   = 'price = :price';
            $params['price'] = $price;
        }

        $query .= implode(', ', $updateParts) . ' WHERE title = :oldTitle';

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }


}