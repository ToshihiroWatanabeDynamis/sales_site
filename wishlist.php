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

    // ほしい物リストに追加
    $stmt = $db->prepare("INSERT INTO wishlist (user_id, album_id) VALUES (:user_id, :album_id)");
    $stmt->execute([
        ':user_id' => $user_id,
        ':album_id' => $album_id
    ]);

    $add_message = "商品がほしい物リストに追加されました。";
}

// 削除処理
if (isset($_POST['remove_from_wishlist']) && isset($_POST['remove_from_wishlist'])) {
    $wishlist_id = e($_POST['remove_from_wishlist']);
    // ほしい物リストから削除
    $stmt = $db->prepare("DELETE FROM wishlist WHERE id = :id AND user_id = :user_id");
    $result = $stmt->execute([
        ':id' => $wishlist_id,
        ':user_id' => $user_id
    ]);

    header('Location: wishlist.php');
}

// ほしい物リストの取得
$stmt = $db->prepare("SELECT wishlist.id AS wishlist_id, albums.* FROM wishlist JOIN albums ON wishlist.album_id = albums.id WHERE wishlist.user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$wishlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>
<body>
    <h2>ほしい物リスト</h2>
    <?php if (empty($wishlist)): ?>
        <p>ほしい物リストに商品がありません。</p>
    <?php else: ?>
        <ul>
            <?= $add_message ?>
            <?php foreach ($wishlist as $item): ?>
                <section class="product-detail">
                    <div class="product-image">
                        <img src="<?= e($item['cover_image']) ?>" alt="<?= e($item['title']) ?>">
                    </div>
                    <div class="product-info">
                        <h1><?= e($item['title']) ?></h1>
                        <p>アーティスト: <?= e($item['artist']) ?></p>
                        <p>価格: ¥<?= e($item['price']) ?></p>
                        <div class="button-group">
                            <a href="cart.php?album_id=<?= e($item['id']) ?>"><button type="submit" name="add_to_cart">カートに追加</button></a>
                        </div>
                        <form action="wishlist.php" method="POST">
                            <button type="submit" name="remove_from_wishlist" value="<?= e($item['wishlist_id']); ?>">削除</button>
                        </form>
                    </div>
                </section>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
<?php require_once 'footer.php'; ?>
