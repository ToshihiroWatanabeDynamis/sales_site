<?php
require_once 'session_manager.php';
require_once 'Encode.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = Database::connectDb();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment = $_POST['payment'];

    // 決済方法の更新処理
    $stmt = $db->prepare("UPDATE users SET payment = :payment WHERE id = :id");
    $stmt->execute([
        ':payment' => $payment,
        ':id' => $user_id
    ]);

    echo "決済方法が更新されました。";
}

// 決済方法の取得
$stmt = $db->prepare("SELECT payment FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>
<body>
    <h2>決済方法登録・更新</h2>

    <form action="payment_update.php" method="POST">
        <label for="payment">決済方法:</label>
        <input type="text" name="payment" value="<?php echo e($user['payment']); ?>" required><br><br>

        <button type="submit">更新</button>
    </form>
</body>
<?php require_once 'footer.php'; ?>
