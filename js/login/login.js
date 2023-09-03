$(document).ready(function () {
    // PC端
    $('#sign-up').on('click', function () {
        $('.main-box').addClass('active')
    })
    $('#sign-in').on('click', function () {
        $('.main-box').removeClass('active')
    })
    // 手机端
    $('#login').on('click', function () {
        $('.sign-in').css({ left: '0%' })
        $('.sign-up').css({ left: '0%' })
    })
    $('#register').on('click', function () {
        $('.sign-in').css({ left: '-50%' })
        $('.sign-up').css({ left: '-50%' })
    })
    // 登录 使用 ajax 来传输数据给 php
    $('.login-pc, .login-mobile').submit(function (event) {
        event.preventDefault()

        let account = $(this)[0][0].value
        let password = $(this)[0][1].value

        $.ajax({
            url: '/lostfound/controller/sign-in.php',
            method: 'post',
            data: { account: account, password: password },
            success: function (response) {
                if (response == 'success') {
                    mdui.snackbar({
                        message: '登陆成功，正在跳转...',
                        position: 'top',
                        timeout: '1000',
                        onOpened: function () {
                            window.location.href = '../view/home.php'
                        },
                    })
                } else if (response == 'over') {
                    mdui.snackbar({
                        message: '登陆失败，账号或密码错误',
                        position: 'top',
                        timeout: '1000',
                    })
                } else {
                    mdui.snackbar({
                        message: '登陆失败，没有找到该用户名',
                        position: 'top',
                        timeout: '1000',
                    })
                }
            },
            error: function () {
                mdui.snackbar({
                    message: '登录失败，发生未知错误。',
                    position: 'top',
                    timeout: '1000',
                })
            },
        })
    })
    // 注册
    $('.register-pc, .register-mobile').submit(function (event) {
        event.preventDefault()

        let account = $(this)[0][0].value
        let password = $(this)[0][1].value
        let contact = $(this)[0][2].value

        $.ajax({
            url: '/lostfound/controller/sign-up.php',
            method: 'post',
            data: { account: account, password: password, contact: contact, audit: 0 },
            success: function (response) {
                console.log(response)
                if (response == 'success') {
                    mdui.snackbar({
                        message: '注册成功，等待审核...',
                        position: 'top',
                        timeout: '1000',
                        onClose: function () {
                            // 注册完之后，需要为user-head文件夹创建一个新的文件夹来放入头像
                            window.location.href = '../view/home.php'
                        },
                    })
                } else {
                    mdui.snackbar({
                        message: '注册失败，该账号或邮箱已被注册。',
                        position: 'top',
                        timeout: '1000',
                    })
                }
            },
            error: function () {
                mdui.snackbar({
                    message: '注册失败，发生未知错误。',
                    position: 'top',
                    timeout: '1000',
                })
            },
        })
    })
})
