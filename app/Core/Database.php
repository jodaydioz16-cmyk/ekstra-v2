<?php
namespace App\Core;
use PDO;
final class Database {
    private PDO $pdo;
    public function __construct() {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', Env::get('DB_HOST', '127.0.0.1'), Env::get('DB_PORT', '3306'), Env::get('DB_DATABASE', 'ekstra_pacet'));
        $this->pdo = new PDO($dsn, Env::get('DB_USERNAME'), Env::get('DB_PASSWORD'), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
    }
    public function pdo(): PDO { return $this->pdo; }
}
