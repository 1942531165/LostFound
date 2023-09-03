<?php
    // 如果没有登录
    if (isset($_SESSION['account']) && isset($_SESSION['password'])) {
        // 判断用户是否为 admin
        $uid = $_SESSION['uid'];
        // 获取role
        $sql = "SELECT role FROM user WHERE uid = :uid";
        $mysqli_stmt = $conn->prepare($sql);
        $mysqli_stmt->bindParam(':uid', $uid);
        $mysqli_stmt->execute();

        $result = $mysqli_stmt->fetch();
        $role = $result['role'];

        // 如果是管理员，那么就需要在右上角的头像部分做出改变
        if ($role == 1) {
            isAdmin();
        } else {
            notAdmin();
        }
        // echo '<script>console.log('.$role.')</script>';
    } else {
        // 显示为登录管理员， 无法查看
        notAdmin();
    }
    function isAdmin() {
        echo <<<JS
        <script>
            $(function() {
                $('.warning').hide(0);
                let width = $(window.outerWidth)[0];
                if (width > 550) {
                    $('.admin-pc').show(0)
                } else {
                    $('.admin-mobile').show(0)
                }
            });
        </script>
        JS;
    }
    function notAdmin() {
        echo <<<JS
        <script>
            $(function() {
                let width = $(window.outerWidth)[0];
                if (width > 550) {
                    $('.admin-pc').hide(0)
                } else {
                    $('.admin-mobile').hide(0)
                }
                if (location.href.indexOf('admin') !== -1) {
                    $('.admin, .main').remove();
                }
            })
            </script>
        JS;
    }
?>