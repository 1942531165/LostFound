<?php
    include_once(__DIR__ . '/conn.php');

    // 获取 库
    $target = $_POST['target'];
    // 获取 选中的 id
    $ids = explode(',', $_POST['ids']);
    // 获取 操作
    $form = $_POST['form'];

    // 判断删除的应该是用户还是数据
    if ($target == 'user-list' || $target == 'user-audit') {
        // 确认操作是 删除 审核 还是 归还
        if ($form == 'delete') {
            // 删除用户
            $sql = "UPDATE user SET dead = 1 WHERE uid = :id";
        } else if ($form == 'audit') {
            // 审核用户
            // 获取审核的值 确定是 通过 还是 不通过
            $audit = $_POST['audit'];
            $sql = "UPDATE user SET audit = '$audit' WHERE uid = :id";
        }
    } else {
        // 确认操作是 删除 审核 还是 归还
        if ($form == 'delete') {
            // 删除数据
            $sql = "UPDATE reports SET dead = 1 WHERE id = :id";
        } else if ($form == 'audit') {
            // 审核数据
            $audit = $_POST['audit'];
            $sql = "UPDATE reports SET audit = '$audit' WHERE id = :id";
        } else {
            // 归还数据
            $result = $_POST['result'];
            $sql = "UPDATE reports SET result = '$result', success_time = NOW() WHERE id = :id";
        }
    }
    $mysqli_stmt = $conn->prepare($sql);

    // 找到所有被选中的数据或者用户
    $successCount = 0;
    foreach ($ids as $id) {
        $mysqli_stmt->bindParam(':id', $id);
        if ($mysqli_stmt->execute()) {
            $successCount++;
        }
    }

    if ($successCount == count($ids)) {
        $response = array(
            'success' => true,
            'count' => $successCount
        );
    } else {
        $response = array(
            'success' => false,
            'count' => count($ids) - $successCount
        );
    }
    echo json_encode($response);

    // 关闭服务器
    $conn = null
?>