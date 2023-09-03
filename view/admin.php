<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员页面</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/iconfont.css">
    <link rel="stylesheet" href="../mdui/css/mdui.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/loading.css">
    <link rel="stylesheet" href="../css/main/card.css">
    <link rel="stylesheet" href="../css/report/inputs.css">
    <link rel="stylesheet" href="../css/report/image-upload.css">
    <!-- 部分作用 -->
    <link rel="stylesheet" href="../css/admin/admin.css">
    <link rel="stylesheet" href="../css/admin/admin-floating.css">
    <link rel="stylesheet" href="../css/admin/admin-search.css">
    <link rel="stylesheet" href="../css/admin/admin-footer.css">
    <link rel="stylesheet" href="../css/admin/admin-add-user.css">
    <link rel="stylesheet" href="../css/admin/admin-add-report.css">
    <link rel="stylesheet" href="../css/admin/admin-read-user.css">
    <link rel="stylesheet" href="../css/admin/admin-read-report.css">
    <link rel="stylesheet" href="../css/admin/admin-edit-user.css">
    <link rel="stylesheet" href="../css/admin/admin-edit-report.css">
    <!-- 手机端 -->
    <link rel="stylesheet" href="../css/phone.css">
    <!-- 必要文件 -->
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../mdui/js/mdui.min.js"></script>
</head>
<?php include '../controller/verify-login.php'; ?>
<?php include '../controller/isadmin.php'; ?>
<body>
    <!-- 遮罩层 -->
    <div class="shade">
        <div class="shadow"></div>
        <!-- 放数据的位置 -->
        <div class="datas"></div>
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
    <!-- 确认 遮罩层 -->
    <div class="floating-shade">
        <div class="shadow"></div>
        <div class="warn">
            <div class="warn-box">
                <div class="warn-title">
                    <div class="warn-head"></div>
                    <div class="warn-tip"></div>
                </div>
                <div class="warn-btns">
                    <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 cancel">取消</button>
                    <button class="mdui-btn mdui-btn-raised mdui-color-indigo confirm">确定</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 新增帖子 -->
    <div class="add-report-shade">
        <div class="shadow"></div>
        <div class="add-report reports">
            <div class="report-box">
                <form method="post" id="add-report">
                    <div class="item">
                        <div class="header">
                            <div class="troduce">
                                <div class="mdui-textfield">
                                    <label class="mdui-textfield-label edit-title">描述</label>
                                    <textarea class="mdui-textfield-input message" name="troduce"></textarea>
                                </div>
                            </div>
                            <div class="state mdui-textfield">
                                <label class="mdui-textfield-label edit-title">状态<span class="tips">*</span></label>
                                <select name="state">
                                    <option value="丢失物品">丢失物品</option>
                                    <option value="捡到物品">捡到物品</option>
                                </select>
                            </div>
                        </div>
                        <div class="thre">
                            <div class="address">
                                <div class="mdui-textfield">
                                    <label class="mdui-textfield-label edit-title">丢失地点</label>
                                    <input class="mdui-textfield-input message" name="address" type="text" />
                                </div>
                            </div>
                            <div class="time">
                                <div class="mdui-textfield">
                                    <label class="mdui-textfield-label edit-title">丢失时间</label>
                                    <input class="mdui-textfield-input message" name="time" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label edit-title">详细信息</label>
                                <textarea class="mdui-textfield-input message" name="info"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="image-upload">
                        <label class="mdui-textfield-label edit-title">上传特征照片</label>
                        <div class="upload-box">
                            <div class="upload mdui-ripple mdui-color-indigo">
                                <i class="mdui-icon material-icons">add</i>
                                <div>上传图片</div>
                            </div>
                            <div class="add">
                                <div class="add-img" edit-title="上传图片">
                                    <img src="/lostfound/asset/upload-image.png">
                                </div>
                            </div>
                        </div>
                        <input name="images[]" class="files" type="file" accept=".jpg,.jpeg,.png" multiple>
                    </div>
                    <div class="personal">
                        <div class="name">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label edit-title">姓名</label>
                                <input class="mdui-textfield-input message" name="real_name" type="text"/>
                            </div>
                        </div>
                        <div class="class">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label edit-title">所在班级</label>
                                <input class="mdui-textfield-input message" name="grades" type="text" />
                            </div>
                        </div>
                        <div class="contact">
                            <div class="mdui-textfield">
                                <label class="mdui-textfield-label edit-title">联系方式</label>
                                <input class="mdui-textfield-input message" name="contact" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="upload-btns">
                        <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 upload-cancel">取消上传</button>
                        <button class="mdui-btn mdui-btn-raised mdui-color-indigo upload-btn">上传帖子</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 新增用户 -->
    <div class="add-user-shade">
        <div class="shadow"></div>
        <div class="add-user">
            <div class="user-box">
                <form method="post" id="add-user">
                    <i class="mdui-icon material-icons cancel-user">close</i>
                    <h3>新增用户</h3>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">account_circle</i>
                        <input class="mdui-textfield-input add-account" name="account" title="请输入用户名" type="text" placeholder="用户名" required/>
                        <div class="mdui-textfield-error">用户名不能为空</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">lock</i>
                        <input class="mdui-textfield-input add-password" name="password" title="请输入密码" type="password" pattern="^.*(?=.{6,}).*$" placeholder="密码" required/>
                        <div class="mdui-textfield-error">密码至少 6 位</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">local_phone</i>
                        <input class="mdui-textfield-input add-phone" name="phone" title="请输入手机号" type="text" pattern="^1[3-9]\d{9}$" placeholder="手机号" required/>
                        <div class="mdui-textfield-error">手机号格式错误</div>
                    </div>
                    <button type="submit" class="mdui-btn mdui-btn-raised mdui-color-indigo add-user-btn">新增用户</button>
                </form>
            </div>
        </div>
    </div>
    <!-- 警告 -->
    <h1 class="warning">你并不是管理员，无法查看后台</h1>
    <!-- 主体 -->
    <div class="mdui-appbar-with-toolbar mdui-loaded admin">
        <div class="mdui-appbar mdui-appbar-fixed mdui-shadow-0">
            <div class="mdui-toolbar mdui-color-indigo">
                <div class="mdui-toolbar-spacer"></div>
                <a class="mdui-typo-headline mobile-title mdui-color-indigo mdui-color-indigo">系统管理面板</a>
                <a class="mdui-typo-headline pc-title mdui-color-indigo mdui-color-indigo">系统管理面板</a>
                <div class="mdui-toolbar-spacer"></div>
                <!-- 尚未登录注册时 -->
                <div class="login">
                    <a href="./login.php" class="mdui-btn mdui-color-indigo-300 mdui-ripple login-btn">登录</a>
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
                                <a href="./personal.php" class="mdui-ripple">个人中心</a>
                            </li>
                            <li class="mdui-menu-item">
                                <a href="./published.php" class="mdui-ripple">发布的内容</a>
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
        <div class="mdui-drawer mdui-drawer-open">
            <ul class="mdui-list" mdui-tab>
                <a class="user-list tab-list mdui-ripple" href="#user-list" flag="true">
                    <li class="mdui-list-item mdui-ripple" >
                        <i class="mdui-list-item-icon mdui-icon material-icons">person</i>
                        <span class="mdui-list-item-content">用户管理</span>
                    </li>
                </a>
                <a class="report-list tab-list mdui-ripple" href="#report-list" flag="false">
                    <li class="mdui-list-item mdui-ripple" >
                        <i class="mdui-list-item-icon mdui-icon material-icons">library_books</i>
                        <span class="mdui-list-item-content">帖子管理</span>
                    </li>
                </a>
                <a class="lost-list tab-list mdui-ripple" href="#lost-list" flag="false">
                    <li class="mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons">edit</i>
                        <span class="mdui-list-item-content">寻物启事管理</span>
                    </li>
                </a>
                <a class="found-list tab-list mdui-ripple" href="#found-list" flag="false">
                    <li class="mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons">location_on</i>
                        <span class="mdui-list-item-content">失物招领管理</span>
                    </li>
                </a>
                <a class="success-list tab-list mdui-ripple" href="#success-list" flag="false">
                    <li class="mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons">done</i>
                        <span class="mdui-list-item-content">成功案例管理</span>
                    </li>
                    <div class="mdui-divider"></div>
                </a>
                <a class="user-audit tab-list mdui-ripple" href="#user-audit" flag="false">
                    <li class="mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons">person_add</i>
                        <span class="mdui-list-item-content">用户审核</span>
                    </li>
                </a>
                <a class="report-audit tab-list mdui-ripple" href="#report-audit" flag="false">
                    <li class="mdui-list-item mdui-ripple">
                        <i class="mdui-list-item-icon mdui-icon material-icons">playlist_add</i>
                        <span class="mdui-list-item-content">帖子审核</span>
                    </li>
                </a>
            </ul>
        </div>
        <div class="main">
            <div class="tools">
                <div class="total"></div>
                <div class="search">
                    <input type="text" placeholder="搜索">
                    <div class="search-btn">
                        <i class="mdui-list-item-icon mdui-icon material-icons">search</i>
                    </div>
                </div>
                <div class="btn-list">
                    <button class="mdui-btn mdui-btn-raised mdui-color-indigo add-btn" mdui-menu="{target: '#add'}">新增数据</button>
                    <ul class="mdui-menu" id="add">
                        <li class="mdui-menu-item">
                            <a class="mdui-ripple add-users">新增用户</a>
                        </li>
                        <li class="mdui-menu-item">
                            <a class="mdui-ripple add-reports">新增失物招领</a>
                        </li>
                    </ul>
                    <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 del-btn">删除数据</button>
                    <button class="mdui-btn mdui-btn-raised mdui-color-indigo special-btn audit-btn verified">审核通过</button>
                    <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 special-btn audit-btn unverified">过审不通过</button>
                    <button class="mdui-btn mdui-btn-raised mdui-color-indigo special-btn return-btn returned">确认归还</button>
                    <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 special-btn return-btn unreturned">仍未归还</button>
                </div>
            </div>
            <div class="data-form" id="user-list">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="user-all">全选</label>
                            <input type="checkbox" id="user-all">
                        </div>
                    </li>
                    <li class="uid">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="account">
                        <div class="title mdui-color-indigo">账号</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">昵称</div>
                    </li>
                    <li class="class">
                        <div class="title mdui-color-indigo">班级</div>
                    </li>
                    <li class="serial">
                        <div class="title mdui-color-indigo">编号</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="role">
                        <div class="title mdui-color-indigo">权限</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <div class="data-form" id="report-list">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="report-all">全选</label>
                            <input type="checkbox" id="report-all">
                        </div>
                    </li>
                    <li class="id">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="troduce">
                        <div class="title mdui-color-indigo">物品</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">详情</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="result">
                        <div class="title mdui-color-indigo">结果</div>
                    </li>
                    <li class="state">
                        <div class="title mdui-color-indigo">状态</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <div class="data-form" id="lost-list">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="lost-all">全选</label>
                            <input type="checkbox" id="lost-all">
                        </div>
                    </li>
                    <li class="id">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="troduce">
                        <div class="title mdui-color-indigo">丢失物品</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">详情</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="result">
                        <div class="title mdui-color-indigo">结果</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <div class="data-form" id="found-list">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="found-all">全选</label>
                            <input type="checkbox" id="found-all">
                        </div>
                    </li>
                    <li class="id">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="troduce">
                        <div class="title mdui-color-indigo">拾获物品</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">详情</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="result">
                        <div class="title mdui-color-indigo">结果</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <div class="data-form" id="success-list">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="success-all">全选</label>
                            <input type="checkbox" id="success-all">
                        </div>
                    </li>
                    <li class="id">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="troduce">
                        <div class="title mdui-color-indigo">物品</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">详情</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="result">
                        <div class="title mdui-color-indigo">结果</div>
                    </li>
                    <li class="state">
                        <div class="title mdui-color-indigo">状态</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <div class="data-form" id="user-audit">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="user-all">全选</label>
                            <input type="checkbox" id="user-all">
                        </div>
                    </li>
                    <li class="uid">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="account">
                        <div class="title mdui-color-indigo">账号</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">昵称</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="role">
                        <div class="title mdui-color-indigo">权限</div>
                    </li>
                    <li class="audit">
                        <div class="title mdui-color-indigo">审核状态</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <div class="data-form" id="report-audit">
                <ul class="list">
                    <li class="checks">
                        <div class="select-all title mdui-color-indigo">
                            <label for="report-all">全选</label>
                            <input type="checkbox" id="report-all">
                        </div>
                    </li>
                    <li class="id">
                        <div class="title mdui-color-indigo">id</div>
                    </li>
                    <li class="troduce">
                        <div class="title mdui-color-indigo">物品</div>
                    </li>
                    <li class="nickname">
                        <div class="title mdui-color-indigo">详情</div>
                    </li>
                    <li class="contact">
                        <div class="title mdui-color-indigo">联系方式</div>
                    </li>
                    <li class="state">
                        <div class="title mdui-color-indigo">状态</div>
                    </li>
                    <li class="audit">
                        <div class="title mdui-color-indigo">审核状态</div>
                    </li>
                    <li class="edit">
                        <div class="title mdui-color-indigo"></div>
                    </li>
                </ul>
            </div>
            <!-- 详细信息 -->
            <div class="footer">
                <div id="p-page" class="page-btn">上一页</div>
                <div class="pages"></div>
                <div id="n-page" class="page-btn">下一页</div>
            </div>
            <!-- 按钮 -->
        </div>
    </div>
</body>
</html>
<script src="../js/all/textarea.js"></script>
<script src="../js/admin/admin.js"></script>
<script src="../js/admin/admin-page.js"></script>
<script src="../js/admin/admin-read.js"></script>
<script src="../js/admin/admin-edit.js"></script>
<script src="../js/admin/admin-add-user.js"></script>
<script src="../js/admin/admin-add-report.js"></script>