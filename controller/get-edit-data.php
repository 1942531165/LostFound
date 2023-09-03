<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    $uid = $_SESSION['uid'];

    // 获取要被修改的数据
    $sql = "SELECT * FROM reports WHERE uid = :uid ORDER BY id DESC";
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->bindParam(':uid', $uid);
    $mysqli_stmt->execute();
    $results = $mysqli_stmt->fetchAll(PDO::FETCH_ASSOC);
    // 返回数据
    echo json_encode($results);

    // 关闭服务器
    $conn = null
?>