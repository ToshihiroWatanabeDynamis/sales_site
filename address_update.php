<?php
require_once 'session_manager.php';
require_once 'Encode.php';


if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$db = Database::connectDb();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = $_POST['address'];

    // 住所の更新処理
    $stmt = $db->prepare("UPDATE users SET address = :address WHERE id = :id");
    $stmt->execute([
        ':address' => $address,
        ':id' => $user_id
    ]);

    echo "住所が更新されました。";
}

// 住所の取得
$stmt = $db->prepare("SELECT address FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>
<body>
    <h2>住所登録・更新</h2>
		<?= isset($user['address']) ?
		'現在の住所: '.e($user['address']) :
		'住所が登録されていません' ?>

    <form action="address_update.php" method="POST">
        <label for="address">住所:</label>
        <input type="text" name="address" value="" required>

        <button type="submit">更新</button>
    </form>
</body>
<?php require_once 'footer.php'; ?>