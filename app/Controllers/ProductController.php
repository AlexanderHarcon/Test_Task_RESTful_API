<?php

namespace App\Controllers;

use App\Storage\QueryService;

class ProductController
{
    private QueryService $queryService;

    public function __construct()
    {
        $this->queryService = new QueryService();
    }

    /**
     * Method can find items by title, quantity, price/
     * Exists an ability to declare limit
     */
    public function findItem(): string
    {
        $requestData = $_GET;

        $title    = null;
        $quantity = null;
        $price    = null;
        $limit    = null;

        if (isset($requestData['title']) && !empty($requestData['title'])) {
            $title = $requestData['title'];
        }
        if (isset($requestData['quantity']) && is_int($requestData['quantity'])) {
            $quantity = $requestData['quantity'];
        }
        if (isset($requestData['price']) && (is_int($requestData['price']) || is_float($requestData['price']))) {
            $price = $requestData['price'];
        }

        if (isset($requestData['limit']) && is_int($requestData['limit'])) {
            $limit = $requestData['limit'];
        }

        $result = $this->queryService->findItem($title, $quantity, $price, $limit);

        return json_encode($result);
    }

    /**
     * Store product into DB
     */
    public function addItem(): string
    {
        $requestData = $_POST;

        $title    = null;
        $quantity = null;
        $price    = null;

        if (isset($requestData['title']) && !empty($requestData['title'])) {
            $title = $requestData['title'];
        }
        if (isset($requestData['quantity']) && is_numeric($requestData['quantity'])) {
            $quantity = (int)$requestData['quantity'];
        }
        if (isset($requestData['price']) && is_numeric($requestData['price'])) {
            $price = (int)$requestData['price'];
        }

        if ($title !== null && $quantity !== null && $price !== null) {
            $result = $this->queryService->addItem($title, $quantity, $price);

            if ($result) {
                return json_encode(['status' => 'success', 'message' => 'Item added successfully']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Failed to add item']);
            }
        }

        return json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    }

    /**
     * Delete product by title
     */
    public function deleteItem(): string
    {
        $request = file_get_contents("php://input");
        $requestData = json_decode($request, true);

        if (isset($requestData['title']) && !empty($requestData['title'])) {
            $title = (string)$requestData['title'];

            $this->queryService->deleteItem($title);

            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Invalid ID provided.']);
        }
    }

    /**
     * Update product by title
     */
    public function updateItem(): string
    {
        $request = file_get_contents("php://input");
        $requestData = json_decode($request, true);

        $oldTitle = $requestData['oldTitle'] ?? null; // Old title
        $newTitle = $requestData['newTitle'] ?? null; // New title
        $quantity = $requestData['quantity'] ?? null;
        $price    = $requestData['price'] ?? null;

        if ($oldTitle && ($newTitle || $quantity || $price)) {
            $result = $this->queryService->updateItem($oldTitle, $newTitle, $quantity, $price);

            return json_encode(['status' => $result ? 'success' : 'error']);
        }

        return json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    }
}

