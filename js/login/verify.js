// 使用 ajax 来验证用户是否登录， 若没有登录， 则不跳转网页， 若登陆了， 则跳转网页
$(function () {
    // 跳转到 主页
    $('.home').on('click', function () {
        window.location.href = '/lostfound/view/home.php'
    })
    // 跳转到 管理员页面
    $('.admin-pc, .admin-mobile').on('click', function () {
        window.location.href = '/lostfound/view/admin.php'
    })
    // 跳转至 失物招领
    $('.report-lost').on('click', function () {
        $.ajax({
            url: '/lostfound/controller/jump.php',
            type: 'POST',
            success: function (response) {
                console.log(response)
                if (response == 'success') {
                    mdui.snackbar({
                        message: '正在跳转至失物招领...',
                        position: 'left-top',
                        timeout: '1000',
                        onOpened: function () {
                            window.location.href = '/lostfound/view/report_lost.php'
                        },
                    })
                } else {
                    mdui.snackbar({
                        message: '请先登录',
                        position: 'top',
                        timeout: '1000',
                    })
                }
            },
        })
    })
    // 跳转至 寻物启事
    $('.report-found').on('click', function () {
        $.ajax({
            url: '/lostfound/controller/jump.php',
            type: 'POST',
            success: function (response) {
                console.log(response)
                if (response == 'success') {
                    mdui.snackbar({
                        message: '正在跳转至寻物启事...',
                        position: 'left-top',
                        timeout: '1000',
                        onOpened: function () {
                            window.location.href = '/lostfound/view/report_found.php'
                        },
                    })
                } else {
                    mdui.snackbar({
                        message: '请先登录',
                        position: 'top',
                        timeout: '1000',
                    })
                }
            },
        })
    })
})
