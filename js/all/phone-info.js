$(function () {
    $.ajax({
        url: '/lostfound/controller/phone-info.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            console.log(data)
            let row = data['row']
            let nickname = data['nickname']
            let image = data['image']
            let head = data['head']
            // 普通数据
            let card_box = basic(row, nickname, 0)
            $('.mdui-card').append(card_box[0])
            // 去掉 展开
            $('.switch').remove()
            // 放图片
            for (let i = 0; i < image.length; i++) {
                let imageDiv = $(`<div class="image" style="background: url('${image[i]}') center center / cover no-repeat;"></div>`)
                $('.image-box>div').append(imageDiv[0])
            }
            // 放头像
            $('.card-box .head').css({
                background: `url(${head}) center center / cover no-repeat`,
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // 处理请求失败的情况
            console.log(errorThrown)
        },
    })
    // 点击按钮回到上一页
    $('.back button').on('click', function () {
        history.back(-1)
    })
})
