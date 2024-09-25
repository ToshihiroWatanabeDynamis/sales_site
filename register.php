<?php
// セッション開始
session_start();

$db = Database::connectDb();
// POSTリクエストが送信された場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームデータを取得
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 入力バリデーション（例: 空欄のチェック）
    if (empty($username) || empty($email) || empty($password)) {
        echo "すべてのフィールドを入力してください。";
        exit;
    }

    // パスワードのハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // メールアドレスの重複チェック
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo "このメールアドレスは既に登録されています。";
        exit;
    }

    // ユーザー情報をデータベースに挿入
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'user')");
    $result = $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);

    if ($result) {
        echo "アカウント登録が成功しました！";
        header('Location: login.php');  // 登録後ログインページにリダイレクト
        exit;
    } else {
        echo "登録に失敗しました。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント登録</title>
</head>
<body>
    <h2>アカウント登録</h2>
    <form action="register.php" method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" required><br><br>

        <label for="email">メールアドレス:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">パスワード:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">登録</button>
    </form>
</body>
</html>