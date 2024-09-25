<?php
require_once 'session_manager.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = Database::connectDb();
$user_id = $_SESSION['user_id'];

if (isset($_POST['confirm_delete'])) {
    // ユーザー削除処理
    $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);

    session_destroy();
    echo "アカウントが削除されました。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント削除</title>
</head>
<body>
    <h2>アカウント削除</h2>

    <form action="delete_account.php" method="POST">
        <p>本当にアカウントを削除しますか？</p>
        <button type="submit" name="confirm_delete">削除する</button>
        <a href="dashboard.php">キャンセル</a>
    </form>
</body>
</html>