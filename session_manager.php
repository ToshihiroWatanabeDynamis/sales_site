<?php
session_start();

// ユーザーがログインしているか確認する関数
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// ロールを確認する関数
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}
?>
