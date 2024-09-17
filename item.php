<?php
class Item {
	private static $countAlbums = 0;
	private $albumId;
	private $albumTitle;
	private $artistName;
	private $genre;
	private $jacketImage;
	private $releaseDate;
	private $price;

	public function __construct($albumTitle, $artistName, $genre, $jacketImage, $releaseDate, $price) {
		$this->albumId = self::$countAlbums;
		$this->albumTitle = $albumTitle;
		$this->artistName = $artistName;
		$this->genre = $genre;
		$this->jacketImage = $jacketImage;
		$this->releaseDate = $releaseDate;
		$this->price = $price;
		self::$countAlbums++;
	}

	public function getTotalCountAlbums() {
		return self::$countAlbums;
	}

	public function getAlbumId() {
		return $this->albumId;
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

	public function getJacketImage() {
		return $this->jacketImage;
	}

	public function getReleaseDate() {
		return $this->releaseDate;
	}

	public function getPrice() {
		return $this->price;
	}

	public static function findByAlbumId(array $albums, int $albumId): ?Item {
		foreach ($albums as $album) {
			if ($album->getAlbumId() == $albumId) {
				return $album;
			}
		}
	}

	public static function searchAlbumsByStr(array $albums, string $str): array {
		$str = mb_convert_case($str, MB_CASE_LOWER);
		return array_filter($albums, fn($album) =>
			(mb_strpos(mb_convert_case($album->getAlbumTitle(), MB_CASE_LOWER), $str) !== false) ||
			(mb_strpos(mb_convert_case($album->getArtistName(), MB_CASE_LOWER), $str) !== false)
		);
	}

	public static function filterByGenre(array $albums, string $genre): array {
		if ($genre === 'all')
			return $albums;
		return array_filter($albums, function($album) use ($genre) {
			return $album->getGenre() === $genre;
		});
	}

	public static function getCommonElements(array $array1, array $array2): array {
		$array2AlbumIds = array_map(fn($item) => $item->getAlbumId(), $array2);
		return array_filter($array1, fn($item) => in_array($item->getAlbumId(), $array2AlbumIds));
	}

	public static function sortAlbums(array $albums, string $sort_by): array {
		if ($sort_by === 'release-date-desc') {
			usort($albums, function($a, $b) {
				$dateA = DateTime::createFromFormat('F j, Y', $a->getReleaseDate());
				$dateB = DateTime::createFromFormat('F j, Y', $b->getReleaseDate());
				return $dateB <=> $dateA;
			});
			return $albums;
		}
		else if ($sort_by === 'release-date-asc') {
			usort($albums, function($a, $b) {
				$dateA = DateTime::createFromFormat('F j, Y', $a->getReleaseDate());
				$dateB = DateTime::createFromFormat('F j, Y', $b->getReleaseDate());
				return $dateA <=> $dateB;
			});
			return $albums;
		}
		return $albums;
	}

}
