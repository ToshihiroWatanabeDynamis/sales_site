<?php
require_once 'Encode.php';

session_start();

$db = Database::connectDb();

// POSTリクエストが送信された場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = e($_POST['email']);
    $password = e($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "すべてのフィールドを入力してください。";
        exit;
    }

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // 'admin'または'user'
        echo "ログイン成功！";
        header('Location: dashboard.php');
        exit;
    } else {
        echo "メールアドレスまたはパスワードが間違っています。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
		<link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>ログイン</h2>
    <form action="login.php" method="POST">
        <label for="email">メールアドレス:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">パスワード:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">ログイン</button>
    </form>
		<p>アカウントをお持ちでない方は <a href="register.php">こちらで登録</a> してください。</p>
</body>
</html>