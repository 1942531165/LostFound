<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发布失物招领</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/iconfont.css">
    <link rel="stylesheet" href="../mdui/css/mdui.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/loading.css">
    <link rel="stylesheet" href="../css/main/pic.css">
    <link rel="stylesheet" href="../css/report/report.css">
    <link rel="stylesheet" href="../css/report/inputs.css">
    <link rel="stylesheet" href="../css/report/image-upload.css">
    <!-- 手机适配 -->
    <link rel="stylesheet" href="../css/phone.css">
    <link rel="stylesheet" href="../css/report/report-phone.css">
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
    <div class="mdui-appbar-with-toolbar mdui-loaded">
        <div class="mdui-appbar mdui-appbar-fixed mdui-shadow-0">
            <div class="mdui-toolbar mdui-color-indigo">
                <a class="mdui-btn mdui-btn-icon menus">
                    <i class="mdui-icon material-icons">menu</i>
                </a>
                <a class="mdui-typo-headline mobile-title">发布失物招领</a>
                <div class="mdui-toolbar-spacer"></div>
                <a class="mdui-typo-headline pc-title">发布失物招领</a>
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
        <form enctype="multipart/form-data" class="upload-lost" method="post">
            <div class="main">
                <div class="main-box reports">
                    <!-- 物品信息 -->
                    <!-- 简单描述 -->
                    <div class="item">
                        <div class="troduce">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label title">描述<span class="tips">*</span></label>
                                <textarea class="mdui-textfield-input message" name="troduce" required></textarea>
                            </div>
                        </div>
                        <div class="thre">
                            <!-- 丢失地点 -->
                            <div class="address">
                                <div class="mdui-textfield">
                                    <label class="mdui-textfield-label title">丢失地点</label>
                                    <input class="mdui-textfield-input message" name="address" type="text" />
                                </div>
                            </div>
                            <!-- 丢失时间 -->
                            <div class="time">
                                <div class="mdui-textfield">
                                    <label class="mdui-textfield-label title">丢失时间</label>
                                    <input class="mdui-textfield-input message" name="time" type="text" />
                                </div>
                            </div>
                        </div>
                        <!-- 详细信息 -->
                        <div class="info">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label title">详细信息<span class="tips">*</span></label>
                                <textarea class="mdui-textfield-input message" name="info" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- 上传图片 -->
                    <div class="image-upload">
                        <label class="mdui-textfield-label title">上传特征照片</label>
                        <div class="upload-box">
                            <!-- 上传图片并发送到指定文件夹 -->
                            <div class="upload mdui-ripple mdui-color-indigo">
                                <i class="mdui-icon material-icons">add</i>
                                <div>上传图片</div>
                            </div>
                            <div class="add">
                                <div class="add-img" title="上传图片">
                                    <img src="/lostfound/asset/upload-image.png">
                                </div>
                            </div>
                        </div>
                        <input name="images[]" class="files" type="file" accept=".jpg,.jpeg,.png" multiple>
                    </div>
                    <!-- 失主信息 -->
                    <!-- 姓名 -->
                    <div class="person">
                        <div class="name">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label title">姓名</label>
                                <input class="mdui-textfield-input message" name="real_name" type="text" />
                            </div>
                        </div>
                        <!-- 所在班级 -->
                        <div class="class">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label title">所在班级</label>
                                <input class="mdui-textfield-input message" name="grades" type="text" />
                            </div>
                        </div>
                        <!-- 联系方式 -->
                        <div class="contact">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label title">联系方式<span class="tips">*</span></label>
                                <input class="mdui-textfield-input message" name="contact" type="text" required />
                            </div>
                        </div>
                    </div>
                    <!-- 发布按钮 -->
                    <div class="publish">
                        <button class="publish-btn mdui-ripple mdui-color-indigo">发布失物招领</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<!-- js -->
<script src="../js/all/all.js"></script>
<script src="../js/all/textarea.js"></script>
<script src="../js/report/report.js"></script>
<script src="../js/login/verify.js"></script>