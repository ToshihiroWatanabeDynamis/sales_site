<?php
require_once 'Item.php';
require_once 'data_.php';
require_once 'Product.php';

$albumId = $_GET['albumId'];
$albums = new searchProduct();
$album = $albums->findById($albumId);
?>

<?php require_once('header.php') ?>
<body>

		<main class="content">
				<section class="product-detail">

						<div class="product-image">
								<img src="<?= "{$album->getCoverImage()}" ?>" alt="<?= "{$album->getAlbumTitle()}" ?>">
						</div>

						<div class="product-info">
								<h1><?= "{$album->getAlbumTitle()}" ?></h1>
								<p>アーティスト: <?= "{$album->getArtistName()}" ?></p>
								<p>ジャンル: <?= "{$album->getGenre()}" ?></p>
								<p>発売日: <?= "{$album->getReleaseDate()}" ?></p>
								<p>価格: ¥<?= "{$album->getPrice()}" ?></p>
								<p>商品説明: ここに商品の詳細な説明が入ります。</p>
								<div class="button-group">
										<button class="wishlist-btn">ほしい物リストに追加</button>
										<button class="cart-btn">カートに入れる</button>
								</div>
						</div>

				</section>
		</main>

</body>
<?php require_once('footer.php') ?>
