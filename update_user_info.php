<?php
require_once 'session_manager.php';
require_once 'Encode.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = Database::connectDb();

// ユーザー情報の取得
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 更新処理
    $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':id' => $user_id
    ]);

    echo "ユーザー情報が更新されました。";
}
?>

<?php require_once 'header.php'; ?>
<body>
    <h2>ユーザー情報更新</h2>

    <form action="update_user_info.php" method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" value="<?php echo e($user['username']); ?>" required><br><br>

        <label for="email">メールアドレス:</label>
        <input type="email" name="email" value="<?php echo e($user['email']); ?>" required><br><br>

				<label for="password">パスワード:</label>
        <input type="password" name="password" value="<?php echo e($user['password']); ?>" required><br><br>

        <button type="submit">更新</button>
    </form>
</body>
<?php require_once 'footer.php'; ?>