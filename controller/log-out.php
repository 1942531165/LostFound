<?php
    // 删除所有的session变量
    $_SESSION = array();
    // 删除sessin id
    // 所以使用setcookie删除包含session id的cookie.
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    // 最后彻底销毁session.
    session_destroy();
    // 因为没有登录，所以自动以游客身份跳转到主页
    header('location:/lostfound/view/home.php');
?>