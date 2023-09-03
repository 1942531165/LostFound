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
    <link rel="stylesheet" href="../css/loading.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- pc端css -->
    <link rel="stylesheet" href="../css/main/search.css">
    <link rel="stylesheet" href="../css/main/card.css">
    <link rel="stylesheet" href="../css/main/pic.css">
    <!-- 手机端 -->
    <link rel="stylesheet" href="../css/phone.css">
    <link rel="stylesheet" href="../css/main/phone-search.css">
    <link rel="stylesheet" href="../css/main/phone-card.css">
    <!-- 必要文件 -->
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
                <a class="mdui-typo-headline mobile-title">失物招领系统</a>
                <div class="mdui-toolbar-spacer"></div>
                <a class="mdui-typo-headline pc-title">智能校园失物招领系统</a>
                <div class="mdui-toolbar-spacer"></div>
                <!-- 尚未登录注册时 -->
                <div class="login">
                    <a href="/lostfound/view/login.php" class="mdui-btn mdui-color-indigo-300 mdui-ripple login-btn">登录</a>
                </div>
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
                                <a class="mdui-ripple">数据管理页面</a>
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
                            <li class="mdui-menu-item admin-mobile">
                                <a class="mdui-ripple">数据管理页面</a>
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
                <li class="mdui-list-item mdui-ripple" id="search">
                    <i class="mdui-list-item-icon mdui-icon material-icons">search</i>
                    <a class="mdui-list-item-content">搜索物品</a>
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
            <!-- 搜索, radio, tab -->
            <div class="search-container">
                <div class="search-input">
                    <input type="text" placeholder="关键词搜索">
                    <div class="search-btn">
                        <i class="mdui-list-item-icon mdui-icon material-icons">search</i>
                    </div>
                </div>
                <!--  radio -->
                <div class="radio">
                    <label for="group1">全部</label>
                    <input type="radio" name="group" id="group1" checked>
                    <label for="group2">只看失物</label>
                    <input type="radio" name="group" id="group2">
                    <label for="group3">只看寻物</label>
                    <input type="radio" name="group" id="group3">
                </div>
                <!-- 手机 radio -->
                <div class="mdui-tab mdui-color-indigo tab" mdui-tab>
                    <a class="mdui-ripple mdui-tab-active" check="group1">全部</a>
                    <a class="mdui-ripple" check="group2">只看失物</a>
                    <a class="mdui-ripple" check="group3">只看招领</a>
                </div>
            </div>
            <!-- 卡片 -->
            <!-- pc端 -->
            <div class="card-list"></div>
            <!-- 卡片 -->
            <!-- 手机端 -->
            <div class="simple-list"></div>
        </div>
        <div class="footer">
            <div class="mdui-btn mdui-btn-raised mdui-color-indigo mdui-ripple more">加载更多</div>
        </div>
        <h1 class="warn">当前尚未有任何帖子<br/>如有需要，请在左侧发布失物招领或者寻物启事</h1>
    </div>
</body>
</html>
<!-- js -->
<script src="../js/all/all.js"></script>
<script src="../js/all/basic.js"></script>
<script src="../js/all/data.js"></script>
<script src="../js/home/home.js"></script>
<script src="../js/home/pic.js"></script>
<script src="../js/login/verify.js"></script>