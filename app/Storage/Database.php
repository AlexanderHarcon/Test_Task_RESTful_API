<?php

namespace App\Storage;

use PDO;
use PDOException;

class Database
{
    private string $host = "localhost";
    private string $db = 'products'; // DB name
    private string $user = 'admin';
    private string $password = 'password';
    private array $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    private PDO $pdo;

    public function __construct()
    {
        try {
            // Creates DSN
            $dsn = "pgsql:host=$this->host;dbname=$this->db";
            $this->pdo = new PDO($dsn, $this->user, $this->password, $this->opt);
        } catch (PDOException $e) {
            echo "Failed to connect to DB: " . $e->getMessage();
        }
    }

    /**
     ** Connection
     **/
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}



