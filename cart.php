<?php
require_once 'session_manager.php';
require_once 'Encode.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$db = Database::connectDb();
$add_message = '';
// 商品の追加処理
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['album_id'])) {
	$album_id = $_GET['album_id'];
    // カートに追加
    $stmt = $db->prepare("INSERT INTO cart (user_id, album_id) VALUES (:user_id, :album_id)");
    $stmt->execute([
        ':user_id' => $user_id,
        ':album_id' => $album_id
    ]);
	$add_message = "商品がカートに追加されました。";
}


// 商品の削除処理
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
	$cart_id = $_POST['remove_from_cart'];

	// カートから削除
	$stmt = $db->prepare("DELETE FROM cart WHERE id = :id AND user_id = :user_id");
	$stmt->execute([
		':id' => $cart_id,
		':user_id' => $user_id
	]);

	header("Location: cart.php");
}

// カート内容の取得
$stmt = $db->prepare("SELECT cart.id AS cart_id, albums.* FROM cart JOIN albums ON cart.album_id = albums.id WHERE cart.user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>
<body>
    <h2>カート</h2>

    <?php if (empty($cart)): ?>
        <p>カートに商品がありません。</p>
    <?php else: ?>
        <ul>
						<?= $add_message ?>
            <?php foreach ($cart as $item): ?>
                <section class="product-detail">
                    <div class="product-image">
                        <img src="<?= e($item['cover_image']) ?>" alt="<?= e($item['title']) ?>">
                    </div>
                    <div class="product-info">
                        <h1><?= e($item['title']) ?></h1>
                        <p>アーティスト: <?= e($item['artist']) ?></p>
                        <p>価格: ¥<?= e($item['price']) ?></p>
                        <form action="cart.php" method="POST">
                            <button type="submit" name="remove_from_cart" value="<?= e($item['cart_id']); ?>">削除</button>
                        </form>
                    </div>
                </section>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
		<a href="checkout.php"><button type="submit" name="checkout">購入画面へ</button></a>
</body>
<?php require_once 'footer.php'; ?>