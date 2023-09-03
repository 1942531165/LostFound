document.write('<script src="/lostfound/js/all/all.js"></script>')
document.write('<script src="/lostfound/js/report/image-upload.js"></script>')
$(function () {
    let imgNum = 0
    let imgList = []
    let oldImg = []
    let newImg = []
    let state = ''
    let id = 0
    let formData
    // 获取的是图片
    loading()
    $.ajax({
        url: '/lostfound/controller/get-edit-data.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // 获取数据
            state = data[index]['state']
            for (let i = 0; i < $('textarea, input').length; i++) {
                if ($('textarea, input')[i].name !== 'images[]') {
                    // 放好除了图片以外的数据
                    $('textarea, input')[i].value = data[index][$('textarea, input')[i].name]
                }
            }
            // 放图片
            id = data[index]['id']
            $.ajax({
                url: '/lostfound/controller/edit-image.php',
                type: 'POST',
                dataType: 'json',
                data: { id: id },
                success: function (data) {
                    data = data[0]
                    // 放入原本就有的图片
                    for (let i = data.length - 1; i >= 0; i--) {
                        let img = $(
                            `<div class="image">
                                <div class="img" style="background: url('${data[i]}') center center / cover no-repeat;">
                                    <div class="delete"><i class="iconfont">&#xeca0;</i></div>
                                </div>
                            </div>`
                        )
                        $('.upload-box').prepend(img)
                        // 初始图片
                        newImg.unshift(data[i])
                    }
                    if ($('.upload-box .image').length !== 0) {
                        imgNum = $('.upload-box .image').length
                    } else {
                        imgNum = 0
                    }
                    imgNums(imgNum)
                    unloading()
                },
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // 处理请求失败的情况
            console.log(errorThrown)
            unloading()
        },
    })
    // 点击返回按钮的时候，跳转回发布的内容
    $('.back-btn').on('click', function () {
        // 跳转回发布物品页面
        mdui.snackbar({
            message: '取消修改，返回中...',
            position: 'left-top',
            timeout: '1000',
            onOpened: function () {
                window.location.href = '/lostfound/view/published.php'
            },
        })
    })
    $('.edit').submit(function (event) {
        loading()
        event.preventDefault()
        // 每次提交都先清空图片
        oldImg = []
        imgList = []
        // 判断最后剩下的图片，如果是File类型的，放入 imgList 中
        // 如果不是，就是初始图片，放入 oldImg 中
        if (newImg.length > 0) {
            for (let i = 0; i < newImg.length; i++) {
                // 如果是，则放入 imgList 中
                if (newImg[i] instanceof File == true) {
                    imgList.push(newImg[i])
                } else {
                    oldImg.push(newImg[i])
                }
            }
        }
        formData = pickInfo(state, $(this), imgList)
        // 如果有 oldImg 则放入 oldImg
        if (oldImg.length > 0) {
            for (let i = 0; i < oldImg.length; i++) {
                formData.append('oldimage[]', oldImg[i])
            }
        }
        // 最后放入 id
        formData.append('id', id)
        // 修改数据
        upload_info(formData, '/lostfound/controller/data-edit.php', '/lostfound/view/published.php')
    })
    // 放入新的图片
    $('.files').on('change', function () {
        for (let i = 0; i < $(this)[0].files.length; i++) {
            newImg.unshift($(this)[0].files[i])
        }
    })
    // 删除图片时将 imgList 中的图片也删除
    $('.upload-box').on('click', '.delete', function () {
        let index = $(this).parent().parent().index()
        newImg.splice(index, 1)
    })
})
// 放入图片后， 查看图片
function imgNums(imgNum) {
    if (imgNum >= 1) {
        $('.upload-box').children('.upload').fadeOut(0)
        $('.add').fadeIn(0)
    } else {
        $('.upload-box').children('.upload').fadeIn(0)
        $('.add').fadeOut(0)
    }
}
