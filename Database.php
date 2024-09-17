<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Database {
	private static $dbInstance = null;

	private function __construct() {}

	public static function connectDb(): PDO {
		if (!isset(self::$dbInstance)) {
			try {
				$host = $_ENV['DB_HOST'];
				$dbname = $_ENV['DB_NAME'];
				$username = $_ENV['DB_USER'];
				$password = $_ENV['DB_PASS'];

				self::$dbInstance = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $username, $password);
				self::$dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		return self::$dbInstance;
	}
}
