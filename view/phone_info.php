<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>失物招领系统</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/iconfont.css">
    <link rel="stylesheet" href="../mdui/css/mdui.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/main/card.css">
    <link rel="stylesheet" href="../css/main/pic.css">
    <!-- 手机适配 -->
    <link rel="stylesheet" href="../css/phone.css">
    <link rel="stylesheet" href="../css/main/phone-info.css">
    <!-- js -->
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../mdui/js/mdui.min.js"></script>
</head>
<?php include '../controller/verify-login.php'; ?>
<?php include '../controller/isadmin.php'; ?>
<body>
    <!-- 图片遮罩层 -->
    <div class="shade">
        <div class="shadow"></div>
        <div class="close"><i class="iconfont">&#xeca0;</i></div>
        <div class="picture">
            <img src="" />
        </div>
        <ul class="tools">
            <li><i class="iconfont small">&#xec13;</i></li>
            <li><i class="iconfont big">&#xec14;</i></li>
            <li><i class="iconfont rotate-l">&#xe670;</i></li>
            <li><i class="iconfont rotate-r">&#xe66f;</i></li>
        </ul>
    </div>
    <!-- 主体 -->
    <div class="mdui-appbar-with-toolbar mdui-loaded">
        <div class="mdui-appbar mdui-appbar-fixed mdui-shadow-0">
            <div class="mdui-toolbar mdui-color-indigo">
                <a class="mdui-btn mdui-btn-icon menus">
                    <i class="mdui-icon material-icons">menu</i>
                </a>
                <a class="mdui-typo-headline mobile-title">失物招领</a>
                <div class="mdui-toolbar-spacer"></div>
                <!-- 尚未登录注册时 -->
                <div class="login">
                    <a class="mdui-btn mdui-color-indigo-300 mdui-ripple login-btn">登录</a>
                </div>
                <!-- 登录注册之后 -->
                <div>
                    <!-- 手机端 -->
                    <div class="user mobile-user">
                        <a class="mdui-btn mdui-btn-icon" mdui-menu="{target: '#mobile-user'}">
                            <div class="head"></div>
                        </a>
                        <ul class="mdui-menu" id="mobile-user">
                            <p>你好，<span class="mobile-user-name"></span></p>
                            <li class="mdui-menu-item">
                                <a href="/lostfound/view/personal.php" class="mdui-ripple">个人中心</a>
                            </li>
                            <li class="mdui-menu-item">
                                <a href="/lostfound/view/published.php" class="mdui-ripple">发布的内容</a>
                            </li>
                            <li class="mdui-menu-item admin-mobile">
                                <a href="/lostfound/view/admin.php" class="mdui-ripple">数据管理页面</a>
                            </li>
                            <li class="mdui-divider"></li>
                            <li class="mdui-menu-item">
                                <a href="/lostfound/controller/log-out.php" class="mdui-ripple log-out">登出</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mdui-drawer mdui-drawer-close">
            <ul class="mdui-list">
                <li class="mdui-list-item mdui-ripple home">
                    <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
                    <a class="mdui-list-item-content">首页</a>
                </li>
                <li class="mdui-list-item mdui-ripple report-lost">
                    <i class="mdui-list-item-icon mdui-icon material-icons">local_offer</i>
                    <a class="mdui-list-item-content">发布寻物启事</a>
                </li>
                <li class="mdui-list-item mdui-ripple report-found">
                    <i class="mdui-list-item-icon mdui-icon material-icons">local_post_office</i>
                    <a class="mdui-list-item-content">发布失物招领</a>
                </li>
            </ul>
        </div>
        <div class="card-list">
            <div class="card-box">
                <div class="mdui-card mdui-shadow-0">
                </div>
            </div>
        </div>
        <div class="back">
            <button class="mdui-btn mdui-btn-raised mdui-color-indigo">返回</button>
        </div>
    </div>
</body>

</html>
<script src="../js/all/all.js"></script>
<script src="../js/all/basic.js"></script>
<script src="../js/all/phone-info.js"></script>
<script src="../js/home/pic.js"></script>
<script src="../js/login/verify.js"></script>