<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    // 判断是主页还是已发布
    $check = $_POST['check'];
    if ($check == 0) {
        // 获取数据 降序排序，确保最新的数据在最上面
        $sql = "SELECT * FROM reports WHERE result = 0 AND dead = 0 AND audit = 1 ORDER BY id DESC";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->execute();
        $row = $mysqli_stmt->fetchAll();
        // 获取头像
        $head = array();
        foreach ($row as $uids) {
            $uid = $uids['uid'];
            // 将头像获取
            $dir = '../user_head/'.$uid.'/user-head.jpg';
            if (file_exists($dir)) {
                // 放入数组中
                $head[] = $dir;
            }
            // 获取 nickname 防止出现用户改名后仍然是以前的名字
            $sql = "SELECT nickname FROM user WHERE uid = '$uid' ORDER BY uid DESC";
            $mysqli_stmt = $conn->prepare($sql);
            $mysqli_stmt->execute();
            $nickname[] = $mysqli_stmt->fetchColumn();
        }
    } else {
        // 根据用户 uid 获取只属于用户的数据
        $sql = "SELECT * FROM reports WHERE uid = :uid AND dead = 0 ORDER BY id DESC";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':uid', $_SESSION['uid']);
        $mysqli_stmt->execute();
        $row = $mysqli_stmt->fetchAll();

        // 获取 nickname
        $sql = "SELECT nickname FROM user WHERE uid = :uid ORDER BY uid DESC";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':uid', $_SESSION['uid']);
        $mysqli_stmt->execute();
        $nickname = $mysqli_stmt->fetchColumn();

        // 获取 该用户 的头像
        $dir = '../user_head/'.$_SESSION['uid'].'/user-head.jpg';
        if (file_exists($dir)) {
            $head = $dir;
        }
    }
    // 获取图片
    $image = array();
    foreach ($row as $ids) {
        $id = $ids['id'];
        // 要获取的路径
        $dir = '../reports_image/'.$id;
        // 获取目录中所有文件的数据
        $files = scandir($dir);
        // 存储图片文件的数组
        $imageUrl = array();
        // 遍历获取的图片
        foreach ($files as $file) {
            // 将前面两个路径排除
            if ($file !== '.' && $file !== '..') {
                // 获取其中的图片$file
                $file_path = $dir.'/'.$file;
                // 获取文件信息
                $file_info = pathinfo($file_path);
                // 将文件信息中的 extension转化为小写
                $extension = strtolower($file_info['extension']);
                // 检查文件是否是图片文件
                if (exif_imagetype($file_path) && ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif')) {
                    // 将文件添加到图片数组中
                    $imageUrl[] = $file_path;
                }
            }
        }
        // 将 $imageUrl 放入 $images 中
        array_push($image, $imageUrl);
    }
    if (count($row) > 0 && count($image) > 0) {
        $data = [
            'row'=>$row,
            'image'=>$image,
            'head'=>$head,
            'nickname'=>$nickname
        ];
        // 返回有效数据
        echo json_encode($data);
    } else {
        // 数据不完整，返回错误信息
        $errorData = [
            'row'=>[]
        ];
        echo json_encode($errorData);
    }
    // 返回数据
    // 关闭服务器
    $conn = null
?>