<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/iconfont.css">
    <link rel="stylesheet" href="../mdui/css/mdui.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/admin/admin-login.css">
    <!-- 手机端 -->
    <link rel="stylesheet" href="../css/phone.css">
    <!-- js -->
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../mdui/js/mdui.min.js"></script>
</head>
<body>
    <div class="mdui-appbar-with-toolbar mdui-loaded">
    <div class="mdui-appbar mdui-appbar-fixed mdui-shadow-0">
        <div class="mdui-toolbar mdui-color-indigo">
            <div class="mdui-toolbar-spacer"></div>
            <a class="mdui-typo-headline mobile-title">后台登录注册</a>
            <a class="mdui-typo-headline pc-title">后台登录注册</a>
            <div class="mdui-toolbar-spacer"></div>
        </div>
    </div>
    <div class="main">
        <form class="form admin-login" method="post">
            <div class="login-box">
                <div class="title">失物招领系统后台</div>
                <div class="title-b">登录界面</div>
                <div class="mdui-textfield">
                    <i class="mdui-icon material-icons">account_circle</i>
                    <input class="mdui-textfield-input login-account" name="account" title="请输入用户名" type="text" placeholder="用户名" required/>
                    <div class="mdui-textfield-error">用户名不能为空</div>
                </div>
                <div class="mdui-textfield">
                    <i class="mdui-icon material-icons">lock</i>
                    <input class="mdui-textfield-input login-password" name="password" title="请输入密码" type="password" pattern="^.*(?=.{6,})(?=.*[a-z]).*$" placeholder="密码" required/>
                    <div class="mdui-textfield-error">密码至少 6 位</div>
                </div>
                <button type="submit" class="btn">登录</button>
            </div>
        </form>
    </div>
</body>
</html>
<script src="../js/admin/admin-login.js"></script>