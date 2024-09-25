<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getDB() :PDO {
	$host = $_ENV['DB_HOST'];
	$dbname = $_ENV['DB_NAME'];
	$username = $_ENV['DB_USER'];
	$password = $_ENV['DB_PASS'];

	$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}

class Database {
    private $host = 'localhost';
    private $dbname = 'cd_sales';
    private $username = 'your_username';
    private $password = 'your_password';
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}

class Album {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // アルバム作成
    public function create($title, $artist, $genre, $cover_image, $release_date, $price) {
        $query = 'INSERT INTO Albums (title, artist, genre, cover_image, release_date, price)
                  VALUES (:title, :artist, :genre, :cover_image, :release_date, :price)';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(compact('title', 'artist', 'genre', 'cover_image', 'release_date', 'price'));
    }

    // アルバム一覧取得
    public function readAll() {
        $query = 'SELECT * FROM Albums';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // アルバム更新
    public function update($id, $title, $artist, $genre, $cover_image, $release_date, $price) {
        $query = 'UPDATE Albums SET title = :title, artist = :artist, genre = :genre, cover_image = :cover_image, release_date = :release_date, price = :price WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(compact('title', 'artist', 'genre', 'cover_image', 'release_date', 'price', 'id'));
    }

    // アルバム削除
    public function delete($id) {
        $query = 'DELETE FROM Albums WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
