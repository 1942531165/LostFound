document.write('<script src="/lostfound/js/all/all.js"></script>')
$(function () {
    // 查看数据
    $('.simple-list').on('click', '.simple-box', function () {
        if (flag == false && del == false) {
            let index = $(this).attr('num')
            // 将 index 记录到 SESSION 中，然后跳转到 phone_info 来显示详情
            $.ajax({
                url: '/lostfound/controller/save-index.php',
                method: 'POST',
                data: { index: index },
                success: function (data) {
                    if (data == 'success') {
                        // 跳转到 phone_info
                        window.location.href = '/lostfound/view/phone_info.php'
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // 处理请求失败的情况
                    console.log(errorThrown)
                },
            })
        } else if ($(this).hasClass('auditing') == true) {
            mdui.snackbar({
                message: '正在审核的内容无法被修改或删除',
                position: 'top',
            })
        }
    })
    // 修改数据
    let flag = false
    let del = false
    $('.edit').on('click', function () {
        // 修改需要跳转到一个网页上修改，修改完成后，点击确认按钮，数据库的数据也会一起修改
        // 停留在edit时显示按钮
        flag = !flag
        del = flags(del, '.delete', '删除')
        if (flag) {
            mdui.snackbar({
                message: '请选择想要修改的帖子',
                position: 'top',
            })
            $(this).text('取消')
            // 将 edit 放入 mdui-card 里面
            if ($(document).width() > 780) {
                $('.card-box')
                    .on('mouseenter', function () {
                        if ($(this).hasClass('success') !== true && $(this).hasClass('auditing') !== true) {
                            edit_fade($(this), '.edit-shade')
                        }
                    })
                    .on('mouseleave', function () {
                        if ($(this).hasClass('success') !== true && $(this).hasClass('auditing') !== true) {
                            edit_fade($(this), '.edit-shade')
                        }
                    })
            } else {
                $('.simple-box').on('click', function () {
                    if ($(this).hasClass('success') !== true && $(this).hasClass('auditing') !== true && flag == true) {
                        let index = $(this).index()
                        saveIndex(index)
                    }
                })
            }
        } else {
            $(this).text('修改')
            $('.card-box').off('mouseenter').off('mouseleave')
        }
    })
    let delIndex = 0
    // 删除数据
    $('.delete').on('click', function () {
        // 删除则会显示一个按钮，点击后确认就会删除，然后将数据库内的数据也一起删除
        // console.log('delete')
        del = !del
        flag = flags(flag, '.edit', '修改')
        if (del) {
            mdui.snackbar({
                message: '请选择想要删除的帖子',
                position: 'top',
            })
            $(this).text('取消')
            // 将 edit 放入 mdui-card 里面
            if ($(document).width() > 780) {
                $('.card-box')
                    .on('mouseenter', function () {
                        if ($(this).hasClass('auditing') !== true) {
                            edit_fade($(this), '.del-shade')
                        }
                    })
                    .on('mouseleave', function () {
                        if ($(this).hasClass('auditing') !== true) {
                            edit_fade($(this), '.del-shade')
                        }
                    })
            } else {
                $('.simple-box').on('click', function () {
                    if ($(this).hasClass('auditing') !== true && del == true) {
                        // 先获取index和uid，方便从数据表中锁定当前点击的帖子
                        delIndex = $(this).index()
                        // 用户点击按钮的时候，跳出提示
                        $('.del-cover').fadeIn(200)
                    }
                })
            }
        } else {
            if ($(this).hasClass('success') !== true && $(this).hasClass('auditing') !== true) {
                $(this).text('删除')
                $('.card-box, .simple-box').off('mouseenter').off('mouseleave')
            }
        }
    })

    // 修改按钮
    $('.card-list').on('click', '.edit-btn', function () {
        let index = $(this).parents('.simple-box, .card-box').index()
        saveIndex(index)
    })
    // 删除按钮
    $('.card-list').on('click', '.del-btn', function () {
        // 先获取index和uid，方便从数据表中锁定当前点击的帖子
        delIndex = $(this).parents('.simple-box, .card-box').index()
        // 用户点击按钮的时候，跳出提示
        $('.del-cover').fadeIn(200)
    })
    // 用户点击了确定按钮，执行删除操作
    $('.confirm').on('click', function () {
        $('.del-cover').fadeOut(200)
        loading()
        // 从数据表获取点击的帖子的数据
        $.ajax({
            url: '/lostfound/controller/get-data.php',
            type: 'POST',
            dataType: 'json',
            data: { check: 1 },
            success: function (data) {
                // console.log(data)
                let row = data['row']
                // 获取响应的id
                let id = row[delIndex]['id']
                // 将id作为参数传过去，让数据库删除该id的所有数据
                $.ajax({
                    url: '/lostfound/controller/del-data.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (data) {
                        mdui.snackbar({
                            message: '删除成功!',
                            position: 'top',
                            timeout: '1000',
                        })
                        if ($(document).width() > 780) {
                            $('.card-box').eq(delIndex).remove()
                        } else {
                            $('.simple-box').eq(delIndex).remove()
                        }
                        unloading()
                    },
                })
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error: ' + textStatus + ' - ' + errorThrown)
            },
        })
    })
    // 用户点击了取消按钮，则什么都不做
    $('.cancel').on('click', function () {
        $('.del-cover').fadeOut(200)
    })
    // 函数
    function flags(flag, target, text) {
        if (flag) {
            flag = false
            $('.card-box').off('mouseenter').off('mouseleave')
            $(target).text(text)
        }
        return flag
    }
    function edit_fade(th, child) {
        th.find(child).stop()
        th.find(child).fadeToggle(200)
    }
    function saveIndex(index) {
        // 将index存储到session中
        $.ajax({
            url: '/lostfound/controller/save-index.php',
            type: 'POST',
            data: { index: index },
            success: function (response) {
                if (response == 'success') {
                    // 跳转到 edit.php
                    window.location.href = '/lostfound/view/edit.php'
                } else {
                    mdui.snackbar({
                        message: '跳转失败，请重新选择!',
                        position: 'top',
                        timeout: '1000',
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // 处理请求失败的情况
                console.log(errorThrown)
            },
        })
    }
})
