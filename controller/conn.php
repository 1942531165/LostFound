<?php
    header('content-type:text/html;charset=utf-8');
    // 登录数据库 $mysql = new MySQLi(主机，账号，密码，数据库，端口号)；
    $host = 'localhost'; // 主机
    $user = 'admin'; // 账号
    $password = 'admin123'; // 密码
    $db = 'lost_and_found'; // 数据库
    // 连接数据库
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    }catch(PDOException $e){
        die("数据库连接失败".$e->getMessage());
    }
?>