<?php
    // 获取POST传递的两个数组
    $newImg = $_POST['newImg'];
    $oldImg = $_POST['oldImg'];
    // 获取id
    $id = $_POST['id'];

    // 路径
    $dir = '../reports_image/'.$id;

    // 列出文件夹中的所有文件和文件夹
    $files = scandir($dir);

    // 删除老图片
    // 先判断 newImg 是否为空，如果为空，则全部删除
    if(empty($newImg)) {
        // 删除所有旧图片
        foreach ($files as $filename) {
            unlink("$dir/$filename");
        }
    } else {
        foreach ($files as $filename) {
            // 如果图片名称不在新数组里面， 则删除该图片， 其余则保留
            if (!in_array("$dir/$filename", $newImg)) {
                unlink("$dir/$filename");
            }
        }
    }
?>
