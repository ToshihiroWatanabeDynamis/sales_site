<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// require_once 'data_.php';
require_once 'Database.php';
require_once 'Product.php';

$products = new searchProduct();
$albums = $products->findAll();
?>

<?php require_once 'header.php'; ?>
<body>
		<main class="content">

				<section class="hero">
						<div class="hero-content">
								<h2>Best Albums of All Time</h2>
						</div>
				</section>

				<section class="album-grid">
						<?php foreach ($albums as $album) { ?>
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
<?php require_once 'footer.php'; ?>
</html>
