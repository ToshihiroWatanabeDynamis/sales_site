<?php
require_once 'session_manager.php';
require_once 'Encode.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$db = Database::connectDb();
// カート内容の取得
$stmt = $db->prepare("SELECT * FROM cart JOIN albums ON cart.album_id = albums.id WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    foreach ($cart as $item) {
        // 購入履歴に追加
        $stmt = $db->prepare("INSERT INTO purchases (user_id, album_id, purchase_date) VALUES (:user_id, :album_id, :purchase_date)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':album_id' => $item['album_id'],
						':purchase_date' => date('Y-m-d')
        ]);
    }

    // カートをクリア
    $stmt = $db->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);

    echo "購入が完了しました！";
		header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>チェックアウト</title>
</head>
<body>
    <h2>カート内容</h2>

    <?php if (empty($cart)): ?>
        <p>カートに商品がありません。</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cart as $item): ?>
                <section class="product-detail">
                    <div class="product-image">
                        <img src="<?= e($item['cover_image']) ?>" alt="<?= e($item['title']) ?>">
                    </div>
                    <div class="product-info">
                        <h1><?= e($item['title']) ?></h1>
                        <p>アーティスト: <?= e($item['artist']) ?></p>
                        <p>価格: ¥<?= e($item['price']) ?></p>
                    </div>
                </section>
            <?php endforeach; ?>
        </ul>

        <form action="checkout.php" method="POST">
            <button type="submit" name="checkout">購入する</button>
        </form>
    <?php endif; ?>
</body>
</html>