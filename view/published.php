<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>已发布内容</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/iconfont.css">
    <link rel="stylesheet" href="../mdui/css/mdui.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/loading.css">
    <link rel="stylesheet" href="../css/main/card.css">
    <link rel="stylesheet" href="../css/personal/published.css">
    <!-- 手机端 -->
    <link rel="stylesheet" href="../css/phone.css">
    <link rel="stylesheet" href="../css/main/phone-card.css">
    <link rel="stylesheet" href="../css/personal/published-phone.css">
    <!-- js -->
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../mdui/js/mdui.min.js"></script>
</head>
<?php include '../controller/verify-login.php'; ?>
<?php include '../controller/isadmin.php'; ?>
<body>
    <!-- 加载中 -->
    <div class="loading-shade">
        <div class="shadow"></div>
        <div class="loading">
            <div class="bar bar1"></div>
            <div class="bar bar2"></div>
            <div class="bar bar3"></div>
            <div class="bar bar4"></div>
            <div class="bar bar5"></div>
            <div class="bar bar6"></div>
            <div class="bar bar7"></div>
            <div class="bar bar8"></div>
        </div>
    </div>
    <!-- 主体 -->
    <div class="mdui-appbar-with-toolbar mdui-loaded">
        <div class="mdui-appbar mdui-appbar-fixed mdui-shadow-0">
            <div class="mdui-toolbar mdui-color-indigo">
                <a class="mdui-btn mdui-btn-icon menus">
                    <i class="mdui-icon material-icons">menu</i>
                </a>
                <a class="mdui-typo-headline mobile-title">发布的内容</a>
                <div class="mdui-toolbar-spacer"></div>
                <a class="mdui-typo-headline pc-title">发布的内容</a>
                <div class="mdui-toolbar-spacer"></div>
                <!-- 登录注册之后 -->
                <div>
                    <!-- pc端 -->
                    <div class="user pc-user">
                        <p>你好，<span class="pc-user-name"></span></p>
                        <a class="mdui-btn mdui-btn-icon" mdui-menu="{target: '#pc-user'}">
                            <div class="head"></div>
                        </a>
                        <ul class="mdui-menu" id="pc-user">
                            <li class="mdui-menu-item">
                                <a href="/lostfound/view/personal.php" class="mdui-ripple">个人中心</a>
                            </li>
                            <li class="mdui-menu-item">
                                <a href="/lostfound/view/published.php" class="mdui-ripple">发布的内容</a>
                            </li>
                            <li class="mdui-menu-item admin-pc">
                                <a href="/lostfound/view/admin.php" class="mdui-ripple">数据管理页面</a>
                            </li>
                            <li class="mdui-divider"></li>
                            <li class="mdui-menu-item">
                                <a href="/lostfound/controller/log-out.php" class="mdui-ripple log-out">登出</a>
                            </li>
                        </ul>
                    </div>
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
                            <li class="mdui-menu-item admin-pc">
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
        <div class="main">
            <!-- 删除的弹窗 -->
            <div class="del-cover">
                <div class="del-screen">
                    <div class="del-main">
                        <div class="del-box">
                            <div class="del-title">
                                <div>你确定要删除这个帖子吗？</div>
                                <div class="tip">（删除之后不可复原）</div>
                            </div>
                            <div class="del-btns">
                                <button class="cancel">取消</button>
                                <button class="confirm">确定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-bar">
                <button class="mdui-btn mdui-btn-raised mdui-color-indigo edit">修改</button>
                <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 delete">删除</button>
            </div>
            <!-- 如果没有发布过，那么显示一串文字 -->
            <div class="no-report">
                <h1>还没有发布过任何的失物招领或者寻物启事哦~</h1>
            </div>
            <!-- PC端 -->
            <div class="card-list">
            </div>
            <!-- 手机端 -->
            <div class="simple-list"></div>
        </div>
</body>
</html>
<script src="../js/all/all.js"></script>
<script src="../js/all/basic.js"></script>
<script src="../js/all/data.js"></script>
<script src="../js/home/home.js"></script>
<script src="../js/publish/publish.js"></script>
<script src="../js/login/verify.js"></script>