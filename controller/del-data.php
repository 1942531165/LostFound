<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    // 获取id
    $id = $_POST['id'];
    // 文件夹路径
    $dir = '../reports_image/'.$id; // 要扫描的目录路径

    // 从数据库删除这个id的数据
    $sql = 'UPDATE reports SET dead = 1 WHERE id = :id';
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->bindParam(':id', $id);
    $mysqli_stmt->execute();

    echo 'success';

    // 关闭服务器
    $conn = null
?>