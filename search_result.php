<?php
require_once 'data_.php';
require_once 'Product.php';

$search_term = isset($_GET['search-term']) ? $_GET['search-term'] : null;
$genre = $_GET['genre'] ;
$sort_by = $_GET['sort-by'];

$products = new searchProduct();
$search_result = $products->searchAndFilter($search_term, $genre, $sort_by);
// $searched_by_string = Item::searchAlbumsByStr($albums, $search_query);
// $filtered_by_genre = Item::filterByGenre($albums, $genre);

// $filtered_albums = Item::getCommonElements($searched_by_string, $filtered_by_genre);
// $search_result = Item::sortAlbums($filtered_albums, $sort_by);


?>

<?php require_once('header.php'); ?>
<body>

		<main class="content">
				<section class="album-grid">
						<?php foreach ($search_result as $album) { ?>
						<article class='album-item'>
								<a href="about_item.php?albumId=<?= "{$album->getId()}" ?>">
										<img src='<?= "{$album->getCoverImage()}" ?>' alt='<?= "{$album->getAlbumTitle()}" ?>'>
										<div class='album-info'>
												<h3><?= "{$album->getAlbumTitle()}" ?></h3>
												<h4><?= "{$album->getArtistName()}" ?></h4>
												<p><?= "{$album->getGenre()}" ?></p>
												<p><?= "{$album->getReleaseDate()}" ?></p>
										</div>
								</a>
						</article>
						<?php } ?>
				</section>
		</main>

</body>
<?php require_once('footer.php'); ?>