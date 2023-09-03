<?php
    include_once(__DIR__ . '/conn.php');
    
    // 获取关键词
    $keyword = $_POST['keyword'];

    // 从简介、物品名称、地址、时间、详细信息、账号、真实姓名、班级、联系方式查找
    // 并且不可以是已经找到的物品 result = 0
    $sql = "SELECT * FROM reports 
        WHERE (troduce LIKE :troduce
            OR address LIKE :address
            OR time LIKE :time
            OR info LIKE :info
            OR real_name LIKE :real_name
            OR grades LIKE :grades
            OR contact LIKE :contact)
            AND result = 0 AND dead = 0 AND audit = 1
            ORDER BY id DESC";
    
    // 执行查询
    $mysqli_stmt = $conn->prepare($sql);
    // 将 关键词 改成模糊查询 添加 %
    $keyword = '%'.$keyword.'%';
    // 使用数组将内容绑定
    $params = array(
        ":troduce"=>$keyword,
        ":address"=>$keyword,
        ":time"=>$keyword,
        ":info"=>$keyword,
        ":real_name"=>$keyword,
        ":grades"=>$keyword,
        ":contact"=>$keyword
    );
    // 使用foreach循环绑定参数
    foreach ($params as $key => $value) {
        $mysqli_stmt->bindValue($key, $value);
    }
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
    $data = [
        'row'=>$row,
        'image'=>$image,
        'head'=>$head,
        'nickname'=>$nickname
    ];
    // 返回数据
    echo json_encode($data);

    // 关闭服务器
    $conn = null
?>