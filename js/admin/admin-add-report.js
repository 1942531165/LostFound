document.write('<script src="/lostfound/js/all/all.js"></script>')
document.write('<script src="/lostfound/js/report/image-upload.js"></script>')
$(function () {
    // 点击“新增数据”可以增加新数据
    $('#add .add-reports').click(function () {
        $('.add-report-shade').fadeIn(200)
        disable_scroll()
    })
    $('.upload-cancel, .add-report-shade .shadow').click(function (e) {
        e.preventDefault()
        $('.add-report-shade').fadeOut(200)
        $(document).unbind('scroll.unable')
    })
    // 点击上传图片的时候
    state = '丢失物品'
    let img_flag = false
    // 初始的模样
    img_flag = changeState(state, img_flag)
    // 修改后的操作
    $('#add-report .state select').on('change', function () {
        state = $(this).val()
        img_flag = changeState(state, img_flag)
    })
    // 上传图片
    let imgList = []
    $('.report-box .files').on('change', function () {
        for (let i = 0; i < $(this)[0].files.length; i++) {
            let size = $(this)[0].files[i].size
            if (size <= 10 * 1024 * 1024) {
                imgList.unshift($(this)[0].files[i])
            }
        }
    })
    // 点击按钮进行提交
    // 创建一个 formData 来保存数据
    let formData
    $('#add-report').submit(function (e) {
        loading()
        e.preventDefault()
        formData = new FormData($(this)[0])
        formData.delete('images[]')
        for (let i = 0; i < imgList.length; i++) {
            formData.append('images[]', imgList[i])
        }
        upload_info(formData, '/lostfound/controller/upload.php', '', true)
        $('shadow').click()
    })
    // 如果删除了一张图片， 则 imgList 少一张
    $('.upload-box').on('click', '.delete', function () {
        let index = $(this).parents('.image').index()
        imgList.splice(index, 1)
    })

    // 修改了 state 函数
    function changeState(state, img_flag) {
        $('.report-box input, .report-box textarea').attr('required', false)
        $('.report-box .tips').remove()
        if (state == '丢失物品') {
            // 如果是失物招领，那么 描述、详细信息、联系方式 不能为空
            $('.troduce textarea, .info textarea, .contact input').attr('required', true)
            $('.troduce label, .info label, .contact label').append($('<span class="tips">*</span>'))
            img_flag = false
        } else {
            // 如果是寻物启事，那么 描述、地点、详细信息、图片、联系方式 不能为空
            $('.troduce textarea, .address input, .info textarea, .contact input').attr('required', true)
            $('.troduce label, .address label, .image-upload label, .info label, .contact label').append($('<span class="tips">*</span>'))
            // 图片不可以为空所以定义 img_flag
            img_flag = true
        }
        return img_flag
    }
})
