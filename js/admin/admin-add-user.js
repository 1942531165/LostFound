document.write('<script src="/lostfound/js/all/all.js"></script>')
$(function () {
    // 点击“新增数据”可以增加新数据
    $('#add .add-users').click(function () {
        // 弹出一个方框，选择新增用户数据还是新增帖子数据
        $('.add-user-shade').fadeIn(200)
        disable_scroll()
    })
    $('.cancel-user, .add-user-shade .shadow').click(function (e) {
        e.preventDefault()
        $('.add-user-shade').fadeOut(200)
        $(document).unbind('scroll.unable')
    })
    // 上传新的用户数据
    $('#add-user').submit(function (e) {
        loading()
        e.preventDefault()
        let account = $(this)[0][0].value
        let password = $(this)[0][1].value
        let contact = $(this)[0][2].value
        $.ajax({
            url: '/lostfound/controller/sign-up.php',
            method: 'post',
            data: { account: account, password: password, contact: contact, audit: 1 },
            success: function (response) {
                console.log(response)
                if (response == 'success') {
                    mdui.snackbar({
                        message: '添加用户成功。',
                        position: 'top',
                        timeout: '1000',
                    })
                    unloading()
                    $('shadow').click()
                } else {
                    mdui.snackbar({
                        message: '添加失败，该账号或手机号已被注册。',
                        position: 'top',
                        timeout: '1000',
                    })
                    unloading()
                }
            },
            error: function () {
                mdui.snackbar({
                    message: '添加失败，发生未知错误。',
                    position: 'top',
                    timeout: '1000',
                })
                unloading()
            },
        })
    })
})
