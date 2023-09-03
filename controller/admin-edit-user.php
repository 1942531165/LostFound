<?php
    include_once(__DIR__ . '/conn.php');

    $uid = $_POST['id'];
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
    // 修改用户的权限
    if(isset($_POST['role']) && $_POST['role'] !== ''){
        if ($_POST['role'] == '管理员') {
            $role = 1;
        } else {
            $role = 0;
        }
        mysql_update($uid, 'role', $role, $conn);
    }
    // 如果获取到了 修改后的值 那么进行修改 否则原封不动
    if(isset($_POST['account']) && $_POST['account'] !== ''){
        // $account存在 替换数据库的account
        $account = $_POST['account'];
        mysql_update($uid, 'account', $account, $conn);
    }
    if(isset($_POST['password']) && $_POST['password'] !== ''){
        // $password存在 替换数据库的password
        $password = $_POST['password'];
        mysql_update($uid, 'password', $password, $conn);
    }
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
    // 如果更换了头像， 那么开始更换， 否则跳过
    if (isset($_FILES['img']) && !empty($_FILES['img']['tmp_name'])) {
        $img = $_FILES['img'];
        // 获取临时的图片文件
        $tempFilePath = $img['tmp_name'];
        // 用户头像路径
        $dir = '../user_head/'.$uid;
        // 路径+图片名称
        $newFilePath = $dir.'/user-head.jpg';
        // 移动 临时图片文件 到 该路径， 并更名为 user-head.jpg
        move_uploaded_file($tempFilePath, $newFilePath);
    }
    // 替换数据库中用户的信息
    echo 'success';

    // 关闭服务器
    $conn = null
?>