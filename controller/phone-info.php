<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    $id = $_SESSION['index'];

    // 获取数据
    $sql = "SELECT * FROM reports WHERE id = :id";
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->bindParam(':id', $id);
    $mysqli_stmt->execute();
    $row = $mysqli_stmt->fetchAll();

    // 获取 头像
    $uid = $row[0]['uid'];
    $filename = '../user_head/' . $uid . '/user-head.jpg';
    $head = file_exists($filename) ? $filename : '';

    // 获取用户昵称
    $sql = "SELECT nickname FROM user WHERE uid = '$uid'";
    $mysqli_stmt = $conn->prepare($sql);
    $mysqli_stmt->execute();
    $nickname = $mysqli_stmt->fetchColumn();

    // 获取图片
    // 要获取的路径
    $dir = '../reports_image/'.$id;
    // 获取目录中所有文件的数据
    $files = scandir($dir);
    // 存储图片文件的数组
    $image = array();
    // 遍历获取的图片
    foreach ($files as $file) {
        // 将前面两个路径排除
        if ($file !== '.' && $file !== '..') {
            // 获取其中的图片$file
            $file_path = $dir . '/' . $file;
            // 获取文件信息
            $file_info = pathinfo($file_path);
            // 将文件信息中的 extension转化为小写
            $extension = strtolower($file_info['extension']);
            // 检查文件是否是图片文件
            if (exif_imagetype($file_path) && ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif')) {
                // 将文件添加到图片数组中
                $image[] = $file_path;
            }
        }
    }
    // 整合数据和头像路径
    $data = [
        'row'=>$row,
        'head'=>$head,
        'image'=>$image,
        'nickname'=>$nickname
    ];
    // 返回结果
    echo json_encode($data);

    // 关闭服务器
    $conn = null;
?>