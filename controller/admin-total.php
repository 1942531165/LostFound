<?php
    include_once(__DIR__ . '/conn.php');

    $target = $_POST['target'];
    $audit = $_POST['audit'];

    if ($target == 'user') {
        // 是用户
        if ($audit == 'true') {
            // 获取审核通过的用户
            $sql = "SELECT * FROM user WHERE audit = 1 AND dead = 0";
        } else {
            // 获取还在审核的用户
            $sql = "SELECT * FROM user WHERE audit = 0 AND dead = 0";
            // 获取帖子
        }
    } else {
        if ($target == 'report') {
            // 是全部帖子
            if ($audit == 'true') {
                // 获取审核通过的全部帖子
                $sql = "SELECT * FROM reports WHERE audit = 1 AND dead = 0";
            } else {
                // 获取还在审核的全部帖子
                $sql = "SELECT * FROM reports WHERE audit = 0 AND dead = 0";
            }
        } else {
            // 是其他帖子
            if (($target == 'lost' || $target == 'found')) {
                if ($target == 'lost') {
                    $state = '丢失物品';
                } else {
                    $state = '捡到物品';
                }
                // 获取失物招领或者寻物启事
                $sql = "SELECT * FROM reports WHERE state = '$state' AND audit = 1 AND dead = 0";
            } else {
                $state = '尚未归还';
                // 获取成功案例
                $sql = "SELECT * FROM reports WHERE success_time != '$state' AND audit = 1 AND dead = 0";
            } 
        }
    }
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->execute();
    $count = $mysqli_stmt->rowCount();

    echo $count;

    // 关闭服务器
    $conn = null
?>