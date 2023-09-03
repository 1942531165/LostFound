<?php
    header('content-type:text/html;charset=utf-8');
    session_start();
    // 获取用户信息
    if (isset($_SESSION['account']) && isset($_SESSION['password'])) {
        // 获取到了 $_SESSION 的账号密码， 发送 success 表示可以跳转
        $account = $_SESSION['account'];
        $password = $_SESSION['password'];
        echo 'success';
    } else {
        // 没有登录， 无法跳转
        echo 'failure';
    }
?>