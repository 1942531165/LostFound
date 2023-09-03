<?php
    session_start();
    include_once(__DIR__ . '/conn.php');

    if (isset($_SESSION['account']) && isset($_SESSION['password'])) {
        // 获取用户信息
        // 登陆成功
        $account = $_SESSION['account'];
        $password = $_SESSION['password'];
        // 登陆成功，获取uid
        $sql = "SELECT uid, nickname, role FROM user WHERE account = :account AND password = :password";
        $mysqli_stmt = $conn->prepare($sql);

        // 放入头像
        $mysqli_stmt->bindParam(':account', $account);
        $mysqli_stmt->bindParam(':password', $password);
        $mysqli_stmt->execute();

        $result = $mysqli_stmt->fetchAll();
        if ($result != false) {

            $uid = $result[0]['uid'];
            $role = $result[0]['role'];
            $nickname = $result[0]['nickname'];
            // 将nickname放入SESSION中
            $_SESSION['nickname'] = $nickname;
            // 将 uid 放入 SESSION 中
            $_SESSION['uid'] = $uid;
                
            loginBtn($nickname);

            echo <<<JS
            <script>
            $(function() {
                $('.head').css({ 'background': 'url(/lostfound/user_head/{$uid}/user-head.jpg) center center / cover no-repeat' })
            })
            </script>
            JS;
        }
    } else {
        // 尚未登录
        echo <<<JS
        <script>
            $(function() {
                $('.login').css({ 'display': 'inline-block' });
                $('.user').css({ 'display': 'none' });
            })
        </script>
        JS;
    }
    // 尚未登录则显示登录按钮
    // 登录之后则显示信息
    function loginBtn($nickname) {
        echo <<<JS
        <script>
        $(function() {
            let width = $(window.outerWidth)[0];
            if (width > 780) {
                $('.user').css({ 'display': 'flex' });
                $('.mobile-user').css({ 'display': 'none' });
                $('.pc-user-name').text('$nickname')
            } else {
                $('.user').css({ 'display': 'flex' });
                $('.pc-user').css({ 'display': 'none' });
                $('.mobile-user-name').text('$nickname')
            }
            $('.login').css({ 'display': 'none' });
        })
        </script>
        JS;
    }
?>