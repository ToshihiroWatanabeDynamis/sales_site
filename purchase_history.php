<?php
require_once 'session_manager.php';
require_once 'Encode.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$db = Database::connectDb();
// 購入履歴の取得
//todo
$stmt = $db->prepare("SELECT purchases.id AS purchases_id, albums.* FROM purchases JOIN albums ON purchases.user_id = albums.id WHERE purchases.user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>
<body>
    <h2>購入履歴</h2>
    <?php if (empty($purchases)): ?>
			<p>購入履歴がありません。</p>
			<?php else: ?>
				<ul>
					<?php foreach ($purchases as $purchase): ?>
                <section class="product-detail">
                    <div class="product-image">
                        <img src="<?= e($purchase['cover_image']) ?>" alt="<?= e($purchase['title']) ?>">
                    </div>
                    <div class="product-info">
                        <h1><?= e($purchase['title']) ?></h1>
                        <p>アーティスト: <?= e($purchase['artist']) ?></p>
                        <p>価格: ¥<?= e($purchase['price']) ?></p>
                    </div>
                </section>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

</body>
<?php require_once 'footer.php'; ?>
