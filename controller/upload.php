<?php
    session_start();
    include_once(__DIR__ . '/conn.php');
    // 判断用户点击的是失物招领还是寻物启事
    $state = $_POST['state'];
    $audit = $_POST['audit'];

    // 获取数据
    // 物品数据
    $troduce = $_POST['troduce']; // 物品简单描述
    $address = $_POST['address']; // 丢失位置
    $time = $_POST['time']; // 丢失时间
    $info = $_POST['info']; // 物品详细信息

    // 失主数据
    $uid = $_SESSION['uid'];
    $real_name = $_POST['real_name']; // 失主姓名
    $grades = $_POST['grades']; // 失主所在班级
    $contact = $_POST['contact']; // 失主联系方式


    // 获取该创建时间
    date_default_timezone_set('PRC'); // 中国时区
    $create_time = date("Y-m-d H:i:s"); // 创建时间

    // 插入数据到失物招领数据库中
    $sql = "INSERT INTO reports
        (troduce, address, time, info,
        uid, real_name, grades, contact, create_time, state)
    VALUE (:troduce, :address, :time, :info,
        :uid, :real_name, :grades, :contact, :create_time, :state)";
    $mysqli_stmt = $conn->prepare($sql);
    // 定义一个 $params 来存储获取的数据
    $params = array(
        ':troduce' => $troduce,
        ':address' => $address,
        ':time' => $time,
        ':info' => $info,
        ':uid' => $uid,
        ':real_name' => $real_name,
        ':grades' => $grades,
        ':contact' => $contact,
        ':create_time' => $create_time,
        ':state' => $state,
    );

    // 使用foreach循环绑定参数
    foreach ($params as $key => $value) {
        $mysqli_stmt->bindValue($key, $value);
    }
    $mysqli_stmt->execute();

    // 图片部分
    // 获取最后一次上传的id
    $id = $conn->lastInsertId();
    // 将id作为路径
    $dir = '../reports_image/'.$id.'/';

    if ($audit == 'true') {
        $sql = "UPDATE reports SET audit = 1 WHERE id = '$id'";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->execute();
    }

    // 如果没有$id为名称的文件夹，则创建一个
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    // 判断是否上传了图片
    if(isset($_FILES['images'])) {
        // 获取图片
        $images = $_FILES['images'];
        // 获取图片的数量
        $count = count($images['name']);

        // 循环$images['name'] 将 $key 作为下标 获取并赋值给 $name
        foreach ($images['name'] as $key => $name) {
            // 获取临时文件的位置
            $tmp_name = $images['tmp_name'][$key];
            $error = $images['error'][$key];
            // 判断是否上传失败， 为 0 表示成功
            if ($error == UPLOAD_ERR_OK) {
                // 将路径和文件名组合
                $destination = $dir . $name;
                // 将临时文件移动到 $dir， 并更名为 $name
                move_uploaded_file($tmp_name, $destination);
            } else {
                echo 'failure';
                // 退出脚本
                exit('上传失败！');
            }
        }
        echo 'success';
    } else {
        echo 'success';
    }

    // 关闭服务器
    $conn = null
?>