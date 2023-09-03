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
    <link rel="stylesheet" href="../css/login/login.css">
    <link rel="stylesheet" href="../css/login/login-phone.css">
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
            <a class="mdui-btn mdui-btn-icon menus">
                <i class="mdui-icon material-icons">menu</i>
            </a>
            <a class="mdui-typo-headline mobile-title">登录注册</a>
            <div class="mdui-toolbar-spacer"></div>
            <a class="mdui-typo-headline pc-title">登录注册</a>
            <div class="mdui-toolbar-spacer"></div>
        </div>
        <div class="mdui-tab mdui-color-indigo" mdui-tab>
            <a id="login" class="mdui-ripple mdui-ripple-white">登录</a>
            <a id="register" class="mdui-ripple mdui-ripple-white">注册</a>
        </div>
    </div>
    <div class="mdui-drawer mdui-drawer-close">
        <ul class="mdui-list">
            <li class="mdui-list-item mdui-ripple home">
                <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
                <a class="mdui-list-item-content">首页</a>
            </li>
        </ul>
    </div>
    <div class="main">
        <!-- pc 端 -->
        <div class="main-box">
            <!-- 登录 -->
            <div class="sign-in">
                <form class="form login-pc" method="post">
                    <h3>登录</h3>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">account_circle</i>
                        <input class="mdui-textfield-input login-account" name="account" title="请输入用户名" maxlength="12" type="text" placeholder="用户名" required/>
                        <div class="mdui-textfield-error">用户名不能为空</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">lock</i>
                        <input class="mdui-textfield-input login-password" name="password" title="请输入密码" maxlength="16" type="password" pattern="^.*(?=.{6,}).*$" placeholder="密码" required/>
                        <div class="mdui-textfield-error">密码至少 6 位</div>
                    </div>
                    <button type="submit" class="btn">登录</button>
                </form>
            </div>
            <!-- 注册 -->
            <div class="sign-up">
                <form class="form register-pc" method="post">
                    <h3>注册</h3>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">account_circle</i>
                        <input class="mdui-textfield-input register-account" name="account" title="请输入用户名" maxlength="12" type="text" placeholder="用户名" required/>
                        <div class="mdui-textfield-error">用户名不能为空</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">lock</i>
                        <input class="mdui-textfield-input register-password" name="password" title="请输入密码" maxlength="16" type="password" pattern="^.*(?=.{6,}).*$" placeholder="密码" required/>
                        <div class="mdui-textfield-error">密码至少 6 位</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">local_phone</i>
                        <input class="mdui-textfield-input register-phone" name="phone" title="请输入手机号" maxlength="15" type="text" placeholder="手机号" required/>
                        <div class="mdui-textfield-error">手机号格式错误</div>
                    </div>
                    <button type="submit" class="btn">注册</button>
                </form>
            </div>
            <!-- Overlay -->
            <div class="overlay-container">
                <div class="overlay">
                    <div class="panel left">
                        <button class="btn" id="sign-in">登录</button>
                    </div>
                    <div class="panel right">
                        <button class="btn" id="sign-up">注册</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 手机端 -->
        <div class="mobile-box">
            <!-- 登录 -->
            <div class="sign-in">
                <form class="form login-mobile" method="post">
                    <h3>登录</h3>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">account_circle</i>
                        <input class="mdui-textfield-input login-account" type="text" placeholder="用户名" required/>
                        <div class="mdui-textfield-error">用户名不能为空</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">lock</i>
                        <input class="mdui-textfield-input login-password" type="password" pattern="^.*(?=.{6,}).*$" placeholder="密码" required/>
                        <div class="mdui-textfield-error">密码至少 6 位</div>
                    </div>
                    <button type="submit" class="btn">登录</button>
                </form>
            </div>
            <!-- 注册 -->
            <div class="sign-up">
            <form class="form register-mobile" method="post">
                <h3>注册</h3>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">account_circle</i>
                        <input class="mdui-textfield-input register-account" type="text" placeholder="用户名" required/>
                        <div class="mdui-textfield-error">用户名不能为空</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">lock</i>
                        <input class="mdui-textfield-input register-password" type="password" pattern="^.*(?=.{6,}).*$" placeholder="密码" required/>
                        <div class="mdui-textfield-error">密码至少 6 位</div>
                    </div>
                    <div class="mdui-textfield">
                        <i class="mdui-icon material-icons">local_phone</i>
                        <input class="mdui-textfield-input register-phone" name="phone" title="请输入手机号" type="text" pattern="^1[3-9]\d{9}$" placeholder="手机号" required/>
                        <div class="mdui-textfield-error">手机号格式错误</div>
                    </div>
                    <button type="submit" class="btn">注册</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script src="../js/all/all.js"></script>
<script src="../js/login/login.js"></script>
<script src="../js/login/verify.js"></script>