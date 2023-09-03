<?php
    include_once(__DIR__ . '/conn.php');

    // 获取状态
    $state = $_POST['state'];

    $audit = "audit = 1 AND dead = 0";
    $unAudit = "audit = 0 AND dead = 0";
    $id = "ORDER BY id DESC";
    $uid = "ORDER BY uid DESC";

    // 根据状态来获取 单独的信息
    if ($state == 'lost' || $state == 'found') {
        // 分状态获取
        if ($state == 'lost') {
            $status = '丢失物品';
        } else {
            $status = '捡到物品';
        }
        $sql = "SELECT * FROM reports WHERE state = :state AND $audit $id";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':state', $status);
    } else if ($state == 'success') {
        // 获取成功案例
        $sql = "SELECT * FROM reports WHERE result = 1 AND $audit $id";
    } else if ($state == 'report') {
        // 全部获取 不分状态
        $sql = "SELECT * FROM reports WHERE $audit $id";
    } else if ($state == 'user') {
        // 获取所有用户
        $sql = "SELECT * FROM user WHERE $audit $uid";
    } else {
        // 获取审核
        if ($state == 'user-audit') {
            $sql = "SELECT * FROM user WHERE $unAudit $uid";
        } else {
            $sql = "SELECT * FROM reports WHERE $unAudit $id";
        }
    }
    if ($state != 'lost' && $state != 'found') {
        $mysqli_stmt = $conn->prepare($sql);
    }
    $mysqli_stmt->execute();
    // 获取并返回给jquery
    $row = $mysqli_stmt->fetchAll();
    // 返回数据
    echo json_encode($row);
    // 关闭服务器
    $conn = null
?>