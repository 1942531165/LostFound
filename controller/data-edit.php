<?php
    include_once(__DIR__ . '/conn.php');

    // 获取id
    $id = $_POST['id'];

    function mysql_update($id, $update_data, $new_data, $conn) {
        // 更新用户数据
        $sql = "UPDATE reports SET $update_data = :$update_data WHERE id = :id";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':id', $id);
        $mysqli_stmt->bindParam($update_data, $new_data);
        $mysqli_stmt->execute();
    }
    // 如果获取到了 修改后的值 那么进行修改 否则原封不动
    if(isset($_POST['troduce']) && $_POST['troduce'] !== ''){
        $troduce = $_POST['troduce'];
        mysql_update($id, 'troduce', $troduce, $conn);
    }
    if(isset($_POST['address']) && $_POST['address'] !== ''){
        $address = $_POST['address'];
        mysql_update($id, 'address', $address, $conn);
    }
    if(isset($_POST['time']) && $_POST['time'] !== ''){
        $time = $_POST['time'];
        mysql_update($id, 'time', $time, $conn);
    }
    if(isset($_POST['info']) && $_POST['info'] !== ''){
        $info = $_POST['info'];
        mysql_update($id, 'info', $info, $conn);
    }
    if(isset($_POST['real_name']) && $_POST['real_name'] !== ''){
        $real_name = $_POST['real_name'];
        mysql_update($id, 'real_name', $real_name, $conn);
    }
    if(isset($_POST['grades']) && $_POST['grades'] !== ''){
        $grades = $_POST['grades'];
        mysql_update($id, 'grades', $grades, $conn);
    }
    if(isset($_POST['contact']) && $_POST['contact'] !== ''){
        $contact = $_POST['contact'];
        mysql_update($id, 'contact', $contact, $conn);
    }
    // 既然修改过了，那么需要重新审核
    $sql = "UPDATE reports SET audit = 0 WHERE id = :id";
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->bindParam(':id', $id);
    $mysqli_stmt->execute();

    // 图片部分
    // 图片地址
    $dir = '../reports_image/'.$id.'/';
    // 获取目标文件夹内的所有文件
    $files = glob($dir . '*');

    if (isset($_POST['oldimage'])) {
        // 如果有图片 则获取
        $oldImg = $_POST['oldimage'];
        // 清空没有在 oldimage中出现的图片
        foreach ($files as $file) {
            $filePath = str_replace('\\', '/', $file); // 修复反斜杠路径问题
            if (!in_array($filePath, $oldImg)) {
                unlink($file);
            }
        }
    } else {
        // 如果没有图片 则将文件夹内的所有图片删除
        foreach ($files as $file) {
            $filePath = str_replace('\\', '/', $file); // 修复反斜杠路径问题
            unlink($file);
        }
    }

    // 判断是否有新增的图片， 有的话增加图片
    if(isset($_FILES['images'])) {
        $images = $_FILES['images'];
        $count = count($images['name']);

        foreach ($images['name'] as $key => $name) {
            $tmp_name = $images['tmp_name'][$key];
            $type = $images['type'][$key];
            $size = $images['size'][$key];
            $error = $images['error'][$key];
            if ($error == UPLOAD_ERR_OK) {
                $destination = $dir . $name;
                move_uploaded_file($tmp_name, $destination);
            } else {
                echo 'failure';
            }
        }
        echo 'success';
    } else {
        echo 'success';
    }
    // 关闭服务器
    $conn = null
?>