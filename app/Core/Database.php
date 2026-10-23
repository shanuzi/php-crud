<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/** Singleton wrapper around PDO. */
final class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $c   = (require __DIR__ . '/../../config/config.php')['db'];
            $dsn = "mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}";
            try {
                self::$instance = new PDO($dsn, $c['user'], $c['pass'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                exit('Database connection failed. Check config/config.php.');
            }
        }
        return self::$instance;
    }
}
