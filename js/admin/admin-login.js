$(function () {
    $('.admin-login').submit(function (event) {
        event.preventDefault()

        let account = $('.login-account').val()
        let password = $('.login-password').val()

        $.ajax({
            url: '../controller/admin-sigh-in.php',
            method: 'post',
            data: { account: account, password: password },
            success: function (response) {
                if (response == 'success') {
                    mdui.snackbar({
                        message: '登录成功，正在跳转...',
                        position: 'top',
                        onOpened: function () {
                            window.location.href = '../view/admin.php'
                        },
                    })
                } else if (response == 'over') {
                    mdui.snackbar({
                        message: '登录失败，账号密码错误',
                        position: 'top',
                    })
                } else if (response == 'sudo') {
                    mdui.snackbar({
                        message: '登录失败，该账号不是管理员',
                        position: 'top',
                    })
                } else {
                    mdui.snackbar({
                        message: '登录失败，未找到该账号',
                        position: 'top',
                    })
                }
            },
            error: function () {
                mdui.snackbar({
                    message: '登录失败，发生未知错误。',
                    position: 'top',
                })
            },
        })
    })
})
