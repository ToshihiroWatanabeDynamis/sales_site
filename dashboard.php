<?php
require_once 'session_manager.php';
require_once 'Encode.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

?>

<?php require_once 'header.php'; ?>
<body>
    <h2><?= 'ようこそ、'.e($_SESSION['username']).'さん！'?></h2>

    <ul>
        <li><a href="update_user_info.php">ユーザー情報設定</a></li>
        <li><a href="address_update.php">住所登録・更新</a></li>
        <li><a href="payment_update.php">決済方法の登録・更新</a></li>
        <li><a href="purchase_history.php">購入履歴</a></li>
        <li><a href="logout.php">ログアウト</a></li>
        <li><a href="delete_account.php">アカウント削除</a></li>
    </ul>
</body>
<?php require_once 'footer.php'; ?>
