<?php
// src/Database/Connection.php
namespace App\Database;

use PDO;
use PDOException;

class Connection {
    private static ?PDO $pdo = null;

    public static function get(): PDO {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../../config/config.php';
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['db']['host'],
                $config['db']['port'],
                $config['db']['name'],
                $config['db']['charset']
            );
            try {
                self::$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo '<h1>Database connection failed</h1>';
                echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
                exit;
            }
        }
        return self::$pdo;
    }
}
