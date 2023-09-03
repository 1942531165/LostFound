<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    // 获取用户的信息
    // 使用session保存的账号从数据库找到用户
    $sql = "SELECT uid, account, nickname, class, serial, contact, email, role, real_name FROM user WHERE account = :account AND password = :password";
    $mysqli_stmt = $conn->prepare($sql);
    // 开始获取 使用登录后给予的 session 来判断账号的 uid
    $mysqli_stmt->bindParam(':account', $_SESSION['account']);
    $mysqli_stmt->bindParam(':password', $_SESSION['password']);
    $mysqli_stmt->execute();
    // 获取并返回给jquery
    $row = $mysqli_stmt->fetchAll();

    // var_dump($row);
    echo json_encode($row);

    // 关闭服务器
    $conn = null
?>