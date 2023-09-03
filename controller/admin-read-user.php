<?php
    include_once(__DIR__ . '/conn.php');

    $id = $_POST['id'];

    // 获取数据
    $sql = "SELECT * FROM user WHERE uid = :uid";
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->bindParam(':uid', $id);
    $mysqli_stmt->execute();
    $row = $mysqli_stmt->fetchAll();
    // 获取 头像
    $filename = '../user_head/' . $id . '/user-head.jpg';
    $head = file_exists($filename) ? $filename : '';

    // 整合数据和头像路径
    $data = [
        'row'=>$row,
        'head'=>$head
    ];
    // 返回结果
    echo json_encode($data);

    // 关闭服务器
    $conn = null;
?>