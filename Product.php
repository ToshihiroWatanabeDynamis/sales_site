<?php
require_once 'Database.php';

class Product {
	private $id;
	private $albumTitle;
	private $artistName;
	private $genre;
	private $averageRating;
	private $releaseDate;
	private $price;

private $coverImage;

	public function __construct($id, $albumTitle, $artistName, $genre, $averageRating, $releaseDate, $price, $coverImage) {
		$this->id = $id;
		$this->albumTitle = $albumTitle;
		$this->artistName = $artistName;
		$this->genre = $genre;
		$this->averageRating = $averageRating;
		$this->releaseDate = $releaseDate;
		$this->price = $price;
		$this->coverImage = $coverImage;
	}

	public function getId() {
		return $this->id;
	}

	public function getAlbumTitle() {
		return $this->albumTitle;
	}

	public function getArtistName() {
		return $this->artistName;
	}

	public function getGenre() {
		return $this->genre;
	}

	public function getAverageRating() {
		return $this->averageRating;
	}

	public function getReleaseDate() {
			return $this->releaseDate;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getCoverImage() {
		return $this->coverImage;
	}
}

class searchProduct {
	private $db;

	public function __construct() {
		$this->db = Database::connectDb();
	}

	private function mapRowToProduct($row) {
		return new Product(
			$row['id'],
			$row['title'],
			$row['artist'],
			$row['genre'],
			$row['average_rating'],
			$row['release_date'],
			$row['price'],
			$row['cover_image']
		);
	}

	public function findAll($orderBy = 'average_rating', $direction = 'DESC') {
		$allowedColumns = ['average_rating', 'id', 'release_date'];
		$allowedDirections = ['ASC', 'DESC'];

		if (!in_array($orderBy, $allowedColumns))
			$orderBy = 'average_rating';
		if (!in_array($direction, $allowedDirections))
			$direction = 'DESC';

		$query = "SELECT * FROM albums ORDER BY $orderBy $direction, id ASC";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$albums[] = $this->mapRowToProduct($row);
		return $albums;
	}

	public function findById($id) {
		$query = "SELECT * FROM albums WHERE id = :id";
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row)
			return $this->mapRowToProduct($row);
		return null;
	}

	public function search($searchTerm, $genre = '') {
		$query = "SELECT * FROM albums WHERE (title LIKE :term OR artist LIKE :term)";
		if ($genre)
			$query .= " AND genre = :genre";

		$stmt = $this->db->prepare($query);
		$term = '%'.$searchTerm.'%';
		$stmt->bindParam(':term', $term, PDO::PARAM_STR);

		if ($genre)
			$stmt->bindParam(':genre', $genre, PDO::PARAM_STR);

		$stmt->execute();

		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$albums[] = $this->mapRowToProduct($row);
		return $albums;
	}

	public function searchAndFilter($searchTerm = '', $genre = '', $orderBy = 'average_rating DESC') {
		$query = "SELECT * FROM albums WHERE 1=1";
		if ($searchTerm)
			$query .= " AND (title LIKE :term OR artist LIKE :term)";
		if ($genre)
			$query .= " AND genre = :genre";
		$query .= " ORDER BY $orderBy, id ASC";

		$stmt = $this->db->prepare($query);

		if ($searchTerm) {
			$term = '%'.$searchTerm.'%';
			$stmt->bindParam(':term', $term, PDO::PARAM_STR);
		}
		if ($genre)
			$stmt->bindParam(':genre', $genre, PDO::PARAM_STR);

		$stmt->execute();

		$albums = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$albums[] = $this->mapRowToProduct($row);

		return $albums;
	}

}

