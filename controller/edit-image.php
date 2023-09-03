<?php
    header('content-type:text/html;charset=utf-8');

    $images = array(); // 存储图片文件的数组
    $id = $_POST['id'];

    $dir = '../reports_image/'.$id; // 要扫描的目录路径
    $files = scandir($dir); // 获取目录中所有文件和子目录的数组
        
    $imageUrl = array(); // 存储图片文件的数组
    $imageSize = array(); // 存储图片大小的数组
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $file_path = $dir . '/' . $file;
            $file_info = pathinfo($file_path);
            $extension = strtolower($file_info['extension']);
            // 检查文件是否是图片文件
            if (exif_imagetype($file_path) && ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif')) {
                $imageUrl[] = $file_path; // 将文件添加到图片数组中
            }
        }
    }

    // 遍历图片路径和大小数组
    array_push($images, $imageUrl);

    echo json_encode($images);
?>