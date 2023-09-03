<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    // 检查用户是否被创建过, 验证的是账号和手机号码
    $sql = "SELECT COUNT(*) FROM user WHERE account = :account OR contact = :contact";
    $mysqli_stmt = $conn->prepare($sql);

    // 预处理SQL语句
    $mysqli_stmt->bindParam(':account', $_POST['account']);
    $mysqli_stmt->bindParam(':contact', $_POST['contact']);
    $mysqli_stmt->execute();

    // 获取查询结果
    $result = $mysqli_stmt->fetchColumn();

    if ($result > 0) {
        echo '你失败了!';
        // 注册失败， 已经有一个相同的账号了
        echo 'failure';
    } else {
        // 插入新注册的数据
        $sql = "INSERT INTO user (account, password, contact, create_time) VALUE (:account, :password, :contact, :create_time)";
        $mysqli_stmt = $conn->prepare($sql);

        // 获取注册的信息
        date_default_timezone_set('PRC'); // 中国时区
        $create_time = date("Y-m-d H:i:s"); // 创建时间

        // 预处理SQL语句
        // 插入新的账号
        $mysqli_stmt->bindParam(':account', $_POST['account']);
        $mysqli_stmt->bindParam(':password', $_POST['password']);
        $mysqli_stmt->bindParam(':contact', $_POST['contact']);
        $mysqli_stmt->bindParam(':create_time', $create_time);
        $mysqli_stmt->execute();

        // 创建一个新的头像文件夹
        // 获取刚刚插入的数据的ID
        $new_id = $conn->lastInsertId();

        // 如果由管理员创建的账号则无需审核
        if ($_POST['audit'] == 1) {
            $sql = "UPDATE user SET audit = 1 WHERE uid = :uid";
            $mysqli_stmt = $conn->prepare($sql);
            $mysqli_stmt->bindParam(':uid', $new_id);
            $mysqli_stmt->execute();
        }

        // 默认昵称就是账号
        $nickname = $_POST['account'];

        $sql = "UPDATE user SET nickname = :nickname WHERE uid = :uid";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':nickname', $nickname);
        $mysqli_stmt->bindParam(':uid', $new_id);
        $mysqli_stmt->execute();
        // 创建新的文件夹
        mkdir("../user_head/{$new_id}");
        // 复制默认头像到新文件夹
        copy("../asset/userhead.jpg", "../user_head/{$new_id}/user-head.jpg");

        // 返回结果
        echo 'success';
    }

    // 关闭服务器
    $conn = null
?>