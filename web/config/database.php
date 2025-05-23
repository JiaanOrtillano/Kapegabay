<?php
namespace root_dev\Config;

define('DB_PATH', __DIR__ . '/../database.sqlite');

class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            try {
                self::$pdo = new \PDO("sqlite:" . DB_PATH);
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                die("Could not connect to the database: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function close() {
        self::$pdo = null;
    }
}