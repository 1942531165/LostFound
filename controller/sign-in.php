<?php
    session_start();
    include_once(__DIR__ . '/conn.php');
    
    // 判断是否拥有该账号
    $sql = "SELECT * FROM user WHERE account = :account AND dead = 0 AND audit = 1";
    $mysqli_stmt = $conn->prepare($sql);

    // 预处理SQL语句
    $mysqli_stmt->bindParam(':account', $_POST['account']);
    $mysqli_stmt->execute();

    if ($mysqli_stmt->rowCount() == 0) {
        // 没有找到账号
        echo 'failure';
    } else {
        // 找到了账号
        $user = $mysqli_stmt->fetch(PDO::FETCH_ASSOC);
        if ($user['password'] != $_POST['password']) {
            // 账号密码不匹配
            echo 'over';
        } else {
            // 登录成功，将用户信息存储在session中，并跳转到主页
            $_SESSION['account'] = $_POST['account'];
            $_SESSION['password'] = $_POST['password'];
            // 返回结果
            echo 'success';
        }
    }

    // 关闭服务器
    $conn = null;
?>