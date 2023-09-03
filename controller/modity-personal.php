<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    $uid = $_POST['uid'];
    // 获取用户修改的信息
    // uid, 修改的位置, 新的值, mysql数据库
    function mysql_update($uid, $update_data, $new_data, $conn) {
        // 更新用户数据
        $sql = "UPDATE user SET $update_data = :$update_data WHERE uid = :uid";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':uid', $uid);
        $mysqli_stmt->bindParam($update_data, $new_data);
        $mysqli_stmt->execute();
    }
    // 如果获取到了 修改后的值 那么进行修改 否则原封不动
    if(isset($_POST['nickname']) && $_POST['nickname'] !== ''){
        // $nickname存在 替换数据库的nickname
        $nickname = $_POST['nickname'];
        mysql_update($uid, 'nickname', $nickname, $conn);
    }
    if(isset($_POST['real_name']) && $_POST['real_name'] !== ''){
        // $real_name存在 替换数据库的real_name
        $real_name = $_POST['real_name'];
        mysql_update($uid, 'real_name', $real_name, $conn);
    }
    if(isset($_POST['class']) && $_POST['class'] !== ''){
        // $class存在 替换数据库的class
        $class = $_POST['class'];
        mysql_update($uid, 'class', $class, $conn);
    }
    if(isset($_POST['serial']) && $_POST['serial'] !== ''){
        // $serial存在 替换数据库的class
        $serial = $_POST['serial'];
        mysql_update($uid, 'serial', $serial, $conn);
    }
    if(isset($_POST['contact']) && $_POST['contact'] !== ''){
        // $contact存在 替换数据库的contact
        $contact = $_POST['contact'];
        mysql_update($uid, 'contact', $contact, $conn);
    }
    if(isset($_POST['email']) && $_POST['email'] !== ''){
        // $email存在 替换数据库的email
        $email = $_POST['email'];
        mysql_update($uid, 'email', $email, $conn);
    }
    // 替换数据库中用户的信息
    echo 'success';

    // 关闭服务器
    $conn = null
?>