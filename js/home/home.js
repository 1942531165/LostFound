$(function () {
    let width = $(document).width()
    // 展开， 收起部分
    $('body').on('click', '.switch span', function () {
        if ($(this).hasClass('more-info')) {
            $(this).siblings().addClass('more-info')
            $(this).removeClass('more-info')
        }
        $(this).parent().siblings().children('.msg').slideToggle()
    })
    // 搜索框显示部分
    // 手机适配
    if (width < 550) {
        // 点击触发
        let flag = true
        $('#search').on('click', function () {
            if (flag) {
                $('.search-container').slideDown(300)
                $('.simple-list').animate({ marginTop: '96px' }, 300)
                flag = !flag
            } else {
                $('.search-container').slideUp(300)
                $('.simple-list').animate({ marginTop: '0' }, 300)
                flag = !flag
            }
        })
    } else {
        $('#search').on('click', function () {
            $('.search-container').slideToggle()
        })
    }
})
