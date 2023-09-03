<?php
    include_once(__DIR__ . '/conn.php');

    // 获取 user
    // 获取关键词
    $keyword = $_POST['keyword'];
    $state = $_POST['state'];

    // 将 关键词 改成模糊查询 添加 %
    $keyword = '%'.$keyword.'%';

    $SReport = "(troduce LIKE :troduce
            OR address LIKE :address
            OR time LIKE :time
            OR info LIKE :info
            OR real_name LIKE :real_name
            OR grades LIKE :grades
            OR contact LIKE :contact)";

    $SUser = "(account LIKE :account
            OR nickname LIKE :nickname
            OR real_name LIKE :real_name
            OR class LIKE :class
            OR serial LIKE :serial
            OR contact LIKE :contact
            OR email LIKE :email)";
    
    $SUserAudit = "(account LIKE :account
            OR nickname LIKE :nickname
            OR contact LIKE :contact)";

    $audit = "AND dead = 0 AND audit = 1";
    $unAudit = "AND dead = 0 AND audit = 0";
    $result = "result = 1";
    $id = "ORDER BY id DESC";
    $uid = "ORDER BY uid DESC";

    $params = array(
        ":troduce"=>$keyword,
        ":address"=>$keyword,
        ":time"=>$keyword,
        ":info"=>$keyword,
        ":real_name"=>$keyword,
        ":grades"=>$keyword,
        ":contact"=>$keyword,
    );

    // 从账号、昵称、真实姓名、班级、学号、联系方式、邮箱查找 符合关键词条件的用户
    if ($state == 'user') {
        $sql = "SELECT * FROM user 
        WHERE $SUser $audit
            $uid";

        $params = array(
            ":account"=>$keyword,
            ":nickname"=>$keyword,
            ":real_name"=>$keyword,
            ":class"=>$keyword,
            ":serial"=>$keyword,
            ":contact"=>$keyword,
            ":email"=>$keyword,
        );
    } else if ($state == 'user-audit') {
        $sql = "SELECT * FROM user 
        WHERE $SUserAudit
            $unAudit
            $uid";

        $params = array(
            ":account"=>$keyword,
            ":nickname"=>$keyword,
            ":contact"=>$keyword,
        );
    } else if ($state == 'lost' || $state == 'found') {
        if ($state == 'lost') {
            $state = '丢失物品';
        } else {
            $state = '捡到物品';
        }
        $sql = "SELECT * FROM reports 
        WHERE $SReport
            AND state = :state $audit
            $id";
    } else if ($state == 'success') {
        $sql = "SELECT * FROM reports 
        WHERE $SReport
            AND result = 1 $audit
            $id";
    } else if ($state == 'report-audit') {
        $sql = "SELECT * FROM reports 
        WHERE $SReport
            $unAudit
            $id";
    } else {
        $sql = "SELECT * FROM reports 
        WHERE $SReport
            $audit
            $id";
    }

    // 执行查询
    $mysqli_stmt = $conn->prepare($sql);

    // 使用foreach循环绑定参数
    foreach ($params as $key => $value) {
        $mysqli_stmt->bindValue($key, $value);
    }
    if ($state == '丢失物品' || $state == '捡到物品') {
        $mysqli_stmt->bindValue(':state', $state);
    }
    $mysqli_stmt->execute();
    $results = $mysqli_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 找到后传回客户端
    echo json_encode($results);

    // 关闭服务器
    $conn = null
?>