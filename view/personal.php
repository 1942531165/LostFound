<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/iconfont.css">
    <link rel="stylesheet" href="../mdui/css/mdui.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/loading.css">
    <link rel="stylesheet" href="../css/personal/personal.css">
    <!-- 手机端 -->
    <link rel="stylesheet" href="../css/phone.css">
    <link rel="stylesheet" href="../css/personal/personal-phone.css">
    <!-- js -->
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery/jquery-ui.min.js"></script>
    <script src="../mdui/js/mdui.min.js"></script>
</head>
<?php include '../controller/verify-login.php'; ?>
<?php include '../controller/isadmin.php'; ?>
<script>
</script>
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
                <a class="mdui-typo-headline mobile-title">个人中心</a>
                <div class="mdui-toolbar-spacer"></div>
                <a class="mdui-typo-headline pc-title">个人中心</a>
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
            <!-- 切换头像的区域 -->
            <div class="shade personal-shade">
                <div class="shadow"></div>
                <!-- 关闭按钮 -->
                <div class="custom-main">
                    <div class="close"><i class="mdui-icon material-icons">close</i></div>
                    <h3 class="title">修改头像</h3>

                    <div class="pic-wrap">
                        <img class="pic1" src="" />
                    </div>
                    <div class="preview-box">
                        <div class="title">浏览图</div>
                        <div class="preview"></div>
                    </div>
                    <div class="custom-bottom">
                        <div class="tips">仅支持JPG，PNG格式，且文件小于10M的图片。<br />请勿使用包含不良信息或敏感内容的图片作为用户头像。</div>
                        <!-- 上传部分 -->
                        <div class="upload-avatar">
                            <input type="file" name="avatar" accept=".jpg,.jpeg,.png" enctype="multipart/form-data">
                            <label class="reselect btn">重新选择图片</label>
                            <div class="done btn">确定</div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="personal-info" method="post">
                <div class="avatar-top">
                    <!-- 头像 -->
                    <div class="avatar-head">
                        <div class="head"></div>
                        <div class="head-shade">
                            <i class="mdui-icon material-icons modify-head">camera_alt</i>
                        </div>
                    </div>
                    <!-- 个人信息 -->
                    <div class="avatar-info">
                        <div>
                            <div>用户名：</div>
                            <div class="account"></div>
                        </div>
                        <div>
                            <div>权限：</div>
                            <div class="role"></div>
                        </div>
                    </div>
                    <!-- 修改个人资料按钮 -->
                    <button class="change-info-btn mdui-btn-raised mdui-color-indigo">修改个人资料</button>
                </div>
                <!-- 显示或修改个人资料 -->
                <div class="avatar-bottom">
                    <div class="show-info">
                        <!-- 用户名 -->
                        <div>
                            <div>昵称：</div>
                            <div class="nickname info" title=""></div>
                            <input data-modify="false" type="text" class="modify-nickname" title="" maxlength="12" value="">
                        </div>
                        <!-- 真实姓名 -->
                        <div>
                            <div>真实姓名：</div>
                            <div class="real_name info" title=""></div>
                            <input data-modify="false" type="text" class="modify-real_name" title="" maxlength="6" value="">
                        </div>
                        <!-- 班级 -->
                        <div>
                            <div>班级：</div>
                            <div class="class info" title=""></div>
                            <input data-modify="false" type="text" class="modify-class" title="" maxlength="12" value="">
                        </div>
                        <!-- 编号 -->
                        <div>
                            <div>编号：</div>
                            <div class="serial info" title=""></div>
                            <input data-modify="false" type="text" class="modify-serial" title="" maxlength="12" value="">
                        </div>
                        <!-- 联系方式 -->
                        <div>
                            <div>联系方式：</div>
                            <div class="contact info" title=""></div>
                            <input data-modify="false" type="text" class="modify-contact" title="" maxlength="11" value="">
                        </div>
                        <!-- 邮箱 -->
                        <div>
                            <div>邮箱：</div>
                            <div class="email info" title=""></div>
                            <input data-modify="false" type="text" class="modify-email" title="" maxlength="20" value="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script src="../js/all/all.js"></script>
<script src="../js/login/verify.js"></script>
<script src="../js/personal/personal.js"></script>