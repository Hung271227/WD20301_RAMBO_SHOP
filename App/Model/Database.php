<?php
require_once __DIR__ . '/../../config.php';
// Kết nối PDO dùng chung (1 kết nối cho toàn bộ request)
class Database {
    private static $pdo = null;
    public function __construct() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                    DB_USER, DB_PASS,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]
                );
            } catch (PDOException $ex) {
                die('Không kết nối được database. Hãy import database/rambo_shop.sql và kiểm tra config.php.<br><small>' . e($ex->getMessage()) . '</small>');
            }
        }
    }
    public function getAll($sql, $p = []) { $s = self::$pdo->prepare($sql); $s->execute($p); return $s->fetchAll(PDO::FETCH_ASSOC); }
    public function getOne($sql, $p = []) { $s = self::$pdo->prepare($sql); $s->execute($p); $r = $s->fetch(PDO::FETCH_ASSOC); return $r ?: null; }
    public function value($sql, $p = []) { $s = self::$pdo->prepare($sql); $s->execute($p); return $s->fetchColumn(); }
    public function action($sql, $p = []) { $s = self::$pdo->prepare($sql); return $s->execute($p); }
    public function lastId() { return (int)self::$pdo->lastInsertId(); }
    public function begin() { self::$pdo->beginTransaction(); }
    public function commit() { self::$pdo->commit(); }
    public function rollBack() { if (self::$pdo->inTransaction()) self::$pdo->rollBack(); }
}
