document.write('<script src="/lostfound/js/all/all.js"></script>')
// 数据部分
$(function () {
    let database = []
    getjson(database)
    // 当点击了修改个人信息之后， 按钮改变， 头像可以改变， 用户可修改自己的信息
    let flag = true
    let count = 0
    $('.change-info-btn').on('click', function (e) {
        e.preventDefault()
        // 修改样式
        $('.info').toggle(0)
        $('.info').siblings('input').toggle(0)
        $('.head-shade').stop().fadeToggle(300)
        if (flag) {
            flag = !flag
            // 修改样式
            $(this).text('保存个人资料').removeClass('mdui-color-indigo').addClass('mdui-color-red-700')
            $('.show-info').addClass('show-active')
            // 开始修改
            count++
            // 如果用户修改了，则改变input的modify值
            $('input').on('input', function () {
                if (database[$(this)[0].classList[0]] !== $(this).val()) {
                    // 用户修改了
                    $(this).attr('data-modify', 'true')
                } else {
                    // 用户没有修改
                    $(this).attr('data-modify', 'false')
                }
            })
        } else {
            // 修改样式
            flag = !flag
            $(this).text('修改个人资料').removeClass('mdui-color-red-700').addClass('mdui-color-indigo')
            $('.show-info').removeClass('show-active')
            // 修改完成
            count++
            $('.personal-info').submit()
        }
    })
    // 将用户修改的信息使用ajax传输给php
    $('.personal-info').on('submit', function (e) {
        e.preventDefault()
        if (count == 2) {
            $('.change-info-btn').prop('disabled', true)
            count = 0
            // 使用formData为ajax传输数据
            let formData = new FormData()
            $('input[data-modify="true"]').each(function () {
                if ($(this)[0].classList[0] !== undefined) {
                    formData.append($(this)[0].classList[0].replace('modify-', ''), $(this).val())
                }
            })
            // 使用formData的entries来获取formData是否拥有数据
            // 如果没有数据，则无需使用ajax传输数据
            let entry = formData.entries()
            if (entry.next().done !== true) {
                // 需要修改，则获取uid
                formData.append('uid', uid)
                $.ajax({
                    url: '/lostfound/controller/modity-personal.php',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        if (response == 'success') {
                            // 修改完资料， 需要将重新获取数据， 并修改页面
                            getjson(database)
                            changeAccount()
                            mdui.snackbar({
                                message: '修改个人资料成功',
                                position: 'top',
                                timeout: '1000',
                            })
                        }
                    },
                    error: function (xhr, status, error) {
                        mdui.snackbar({
                            message: '修改失败，发生未知问题！',
                            position: 'top',
                            timeout: '1000',
                        })
                    },
                })
            } else {
                mdui.snackbar({
                    message: '您尚未做出任何修改',
                    position: 'top',
                    timeout: '1000',
                })
            }
            unloading()
            $('.change-info-btn').prop('disabled', false)
        }
    })
    // 头像
    // 头像部分
    let head = $('.head')[0].style.backgroundImage.split('"')[1]
    if ($(document).width() > 780) {
        // 获取用户的uid
        let uid = $('.head')[0].style.backgroundImage.split('/')[3]
        $('.pic1').attr('src', head)
        // 更改头像， 顺便加上时间戳确保更新图片
        let timeStamp = new Date().getTime()
        $('.preview').css('background', `url(${head}?timestamp=${timeStamp}) center center / cover no-repeat`)
        // 点击空白处或者叉号退出更换头像界面
        $('.shadow, .close').on('click', function () {
            $('.shade').fadeOut(500)
        })
        // 点击head-shade时候，显示更换头像界面
        $('.head-shade').on('click', function () {
            $('.shade').fadeIn(500)
            get_head()
        })
        // 点击更换头像按钮
        $('.reselect').on('click', function () {
            $('.upload-avatar input').click()
        })
        // 上传头像
        let img
        $('.upload-avatar input').change(function () {
            img = $(this)[0].files[0]
            // 创建一个 FileReader 对象，用于读取文件数据
            let reader = new FileReader()
            reader.readAsDataURL(img)
            // 替换路径
            // 当fileReader准备完毕后，替换地址
            reader.onload = function (e) {
                // 将图片元素的 src 属性设置为数据 URL
                $('.pic1')
                    .attr('src', e.target.result)
                    // 等待图片准备完毕后
                    .on('load', function () {
                        $('.pic1').hide(0)
                        get_head()
                    })
                $('.preview').css('background', `url(${e.target.result}) center center / cover no-repeat`)
            }
        })
        // 点击确定按钮的时候，获取缩略框显示的图片，并生成一张新的图片
        $('.done').on('click', function () {
            // 获取图片
            if (img !== undefined) {
                replace_head(img, uid, head)
            }
            $('.shade').fadeOut(500)
        })
    } else {
        // 点击更换头像的时候直接选择图片，选好之后直接替换
        $('.head-shade').on('click', function () {
            $('.upload-avatar input').click()
        })
        // 上传头像
        let img,
            uid = $('.head')[0].style.backgroundImage.split('/')[3]
        $('.upload-avatar input').change(function () {
            img = $(this)[0].files[0]
            replace_head(img, uid, head)
        })
        $('.shade').fadeOut(500)
    }
})
// 获取头像，并将其展示到页面上
function get_head() {
    // 当图片加载完的时候
    // 获取图片的宽高
    $('.pic1').show(0)

    let width = $('.pic1').width()
    let height = $('.pic1').height()

    // 图片根据自身大小来改变宽高
    if (width < 280 && height >= 280) {
        $('.pic1').css({ 'max-height': height })
    } else if (height < 280 && width >= 280) {
        $('.pic1').css({ 'max-width': width })
    } else {
        width = 280
        height = 280
        $('.pic1').css({ 'max-width': width, 'max-height': height })
    }
}
// 获取数据并修改
let uid
function getjson(database) {
    loading()
    $.getJSON('/lostfound/controller/personal-info.php', function (data) {
        data = data[0]
        let record = ['account', 'nickname', 'real_name', 'class', 'serial', 'contact', 'email']
        // 写入数据
        for (let i = 0; i < record.length; i++) {
            $('.' + record[i]).text(data[record[i]])
            $('.' + record[i]).attr('title', data[record[i]])
            $('.modify-' + record[i]).val(data[record[i]])
            $('.modify-' + record[i]).attr('title', data[record[i]])
            database['modify-' + record[i]] = data[record[i]]
        }
        // console.log(database)
        // 权限比较特殊， 0为普通用户， 1为管理员
        if (data['role'] == 0) {
            $('.role').text('普通用户')
        } else if (data['role'] == 1) {
            $('.role').text('管理员')
        }
        // 获取用户的 id
        uid = data['uid']
        unloading()
    })
}
// 修改右上角的用户名
function changeAccount() {
    $.getJSON('/lostfound/controller/personal-info.php', function (data) {
        data = data[0]
        // 更改值
        $('.pc-user-name').text(data['nickname'])
        $('.mobile-user-name').text(data['nickname'])
    })
}