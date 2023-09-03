document.write('<script src="/lostfound/js/all/all.js"></script>')
$(function () {
    let imageObj = { class: 'image' }
    let del = `<div class="delete"><i class="iconfont">&#xeca0;</i></div>`
    // 创建一个变量, 用来勘察是否上传了图片
    let imgNum = 0
    // 创建 img
    $('.main, .datas').on('click', '.upload, .add', function () {
        // 相当于点击上传图片了
        $('.main .files, .datas .files').click()
        console.log(1)
    })
    $('.add-report').on('click', '.upload, .add', function () {
        // 相当于点击上传图片了
        $('.add-report .files').click()
    })
    // 点击上传按钮时
    let imgObj = {
        class: 'img',
        css: {
            backgroundPosition: 'center center',
            backgroundSize: 'cover',
            backgroundRepeat: 'no-repeat',
        },
    }
    // 上传完毕时
    $('.main, .datas, .add-report').on('change', '.files', function () {
        let files = this.files
        let length = files.length

        // 循环准备放入页面
        for (let i = 0; i < length; i++) {
            // 先判断图片的大小是否超过10MB
            let size = files[i].size
            let name = files[i].name
            if (size > 10 * 1024 * 1024) {
                // 图片超过大小，拒绝上传
                mdui.snackbar({
                    message: name + ' 大小超过10MB，不可上传',
                    timeout: '1000',
                })
                // 直接跳过这一张图片
                return true
            }

            let fileReader = new FileReader() //实例化一个FileReader对象
            let file_ = files[i] //获取当前文件
            fileReader.readAsDataURL(file_)
            // 创建整体
            let img = $('<div>', imgObj)
            let image = $('<div>', imageObj)

            fileReader.onload = function () {
                //当读取操作完成时调用
                img.css('background-image', 'url(' + this.result + ')')
            }
            $(this).siblings('.upload-box').prepend(image)
            image.append(img)
            img.html(del)
        }
        imgNum = $('.upload-box').children('.image').length
        imgNums(imgNum)
        mdui.snackbar({
            message: '图片添加成功',
            timeout: '1000',
        })
    })
    // 添加删除图片
    $('.main, .datas, .add-report').on('mouseenter', '.upload-box .img', function () {
        $(this).children('.delete').stop()
        $(this).children('.delete').fadeIn(100)
    })
    $('.main, .datas, .add-report').on('mouseleave', '.upload-box .img', function () {
        $(this).children('.delete').stop()
        $(this).children('.delete').fadeOut(100)
    })
    $('.main, .datas, .add-report').on('click', '.upload-box .delete', function () {
        $(this).parent().parent().remove()
        imgNum = $('.upload-box').children('.image').length
        imgNums(imgNum)
    })
})
// 上传数据
function pickInfo(state, btn, imgList) {
    let formData = new FormData(btn[0])
    formData.append('state', state)
    formData.delete('images[]')
    for (let i = 0; i < imgList.length; i++) {
        formData.append('images[]', imgList[i])
    }
    // for (let [a, b] of formData.entries()) {
    //     console.log(a, b, '--------------')
    // }
    // console.log(imgList)
    return formData
}
function upload_info(formData, url, href, audit) {
    if (formData.get('state') == '捡到物品' && formData.get('oldimage[]') == null && formData.get('images[]') == null) {
        mdui.snackbar({
            message: '请上传特征照片！',
            position: 'top',
            timeout: '1000',
        })
    } else {
        // 放入 audit
        formData.append('audit', audit)
        // 释放新数据
        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response == 'success') {
                    mdui.snackbar({
                        message: '提交完成，正在跳转...',
                        position: 'top',
                        timeout: '1000',
                        onOpened: function () {
                            // 滚动条不再限制滚动
                            $(document).unbind('scroll.unable')
                            $('.loading-shade').hide(0)
                            if (href !== '') {
                                window.location.href = href
                            }
                            unloading()
                        },
                    })
                } else {
                    mdui.snackbar({
                        message: '上传失败，请重试...',
                        position: 'top',
                        timeout: '1000',
                    })
                }
            },
            error: function () {
                mdui.snackbar({
                    message: '提交失败，发生未知问题！',
                    position: 'top',
                    timeout: '1000',
                })
            },
        })
    }
}
// 如果 imgNum 数量 >= 1 则按钮消失, 变成一个图片表示上传
function imgNums(imgNum) {
    if (imgNum >= 1) {
        $('.upload-box').children('.upload').fadeOut(0)
        $('.add').fadeIn(0)
    } else {
        $('.upload-box').children('.upload').fadeIn(0)
        $('.add').fadeOut(0)
    }
}
