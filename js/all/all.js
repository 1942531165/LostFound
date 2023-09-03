$(function () {
    let md$ = mdui.$
    // 移动drawer
    let flag = false
    let drawer = new mdui.Drawer('.mdui-drawer')
    md$('.menus').on('click', function () {
        drawer.toggle(300)
        flag = !flag
        if (flag) {
            $('.main-box').css({ width: '80%' })
        } else {
            $('.main-box').css({ width: '60%' })
        }
    })
})
// 显示阴影
function loading() {
    $('.loading-shade').show(0)
    // 禁止滚动条进行滚动
    let top = $(document).scrollTop()
    $(document).on('scroll.unable', function (e) {
        $(document).scrollTop(top)
    })
}
function unloading() {
    // 滚动条不再限制滚动
    $(document).unbind('scroll.unable')
    $('.loading-shade').hide(0)
}
// 替换头像
function replace_head(img, uid, head) {
    loading()
    let formData = new FormData()
    formData.append('img', img)
    formData.append('uid', uid)
    // 将地址 图片名称 id 一起传入php
    $.ajax({
        url: '/lostfound/controller/replace-head.php',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (data) {
            // 替换头像
            let timeStamp = new Date().getTime()
            $('.head').css('background', `url(${head}?timestamp=${timeStamp}) center center / cover no-repeat`)
            mdui.snackbar({
                message: '修改头像成功',
                position: 'top',
                timeout: '1000',
            })
            unloading()
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText)
        },
    })
}
