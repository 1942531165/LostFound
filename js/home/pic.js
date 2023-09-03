// 网页中点击图片将其放大
// 并且可以选中或者拖动
$(function () {
    // 按下鼠标，准备移动
    let currentX = 0,
        currentY = 0
    let left = 0,
        top = 0
    let nowX = 0,
        nowY = 0
    let disX = 0,
        disY = 0
    $('.picture img').bind('mousedown', start)
    let flag = false
    function start(event) {
        flag = true
        if (!event) {
            event = window.event
            //防止IE文字选中
            bar.onselectstart = function () {
                return false
            }
        }
        var e = event
        currentX = e.clientX
        currentY = e.clientY
        // 移动鼠标，拖动图片
        $('.shade').bind('mousemove', function (event) {
            var e = event ? event : window.event
            if (flag) {
                nowX = e.clientX
                nowY = e.clientY
                disX = nowX - currentX
                disY = nowY - currentY
                $('.picture img').css({ marginLeft: parseInt(left) + disX * 2 + 'px' })
                $('.picture img').css({ marginTop: parseInt(top) + disY * 2 + 'px' })

                if (event.preventDefault) {
                    event.preventDefault()
                }
                return false
            }
        })
    }
    // 松开鼠标，移动结束，固定位置
    $(document).bind('mouseup', function () {
        flag = false
        left = $('.picture img').css('marginLeft')
        top = $('.picture img').css('marginTop')
    })

    // 图片的工具组
    let rotate = 0
    let size = 1
    $('.tools li i').click(function () {
        if ($(this).hasClass('rotate-l')) {
            // 顺时针 90°
            rotate -= 90
        } else if ($(this).hasClass('rotate-r')) {
            // 逆时针 90°
            rotate += 90
        } else if ($(this).hasClass('big')) {
            // 图片放大
            size += 0.1
        } else if ($(this).hasClass('small')) {
            // 图片缩小
            size -= 0.1
        }
        if (rotate >= 360 || rotate <= -360) {
            rotate = 0
        }
        if (size >= 3) {
            size = 3
        } else if (size <= 0.1) {
            size = 0.1
        }
        $('.picture img').css('transform', 'rotate(' + rotate + 'deg) scale(' + size + ')')
    })
    // 滚轮控制图片大小
    let wheel = true
    function wheels() {
        wheel = event.wheelDelta > 0
        if (wheel) {
            size += 0.05
        } else {
            size -= 0.05
        }
        // 防止出现bug， 在判断一次
        if (size >= 3) {
            size = 3
        } else if (size <= 0.1) {
            size = 0.1
        }
        $('.picture img').css('transform', 'rotate(' + rotate + 'deg) scale(' + size + ')')
        return false
    }
    document.addEventListener('mousewheel', wheels, { passive: false })
    // 点击关闭按钮进行关闭
    $('.shadow, .close').click(function () {
        $('.shade').hide(0)
        // 滚动条不再限制滚动
        $(document).unbind('scroll.unable')
        // 清空已经动过的值
        setTimeout(() => {
            rotate = 0
            size = 1
            $('.picture img').css({
                marginLeft: '0px',
                marginTop: '0px',
                transform: 'rotate(' + rotate + 'deg) scale(' + size + ')',
            })
        }, 0)
    })
    // 每次点击图片时，清空数值，限制滚动，更新图片
    $('body').on('click', '.image-box .image', open)
    function open() {
        // 禁止滚动条进行滚动
        let top = $(document).scrollTop()
        $(document).on('scroll.unable', function (e) {
            $(document).scrollTop(top)
        })
        // 将图片更新
        if ($(this).css('backgroundImage') !== 'none') {
            $('.picture img').attr('src', $(this).css('backgroundImage').split('"')[1])
            $('.picture img').on('load', function () {
                $('.shade').show(0)
            })
        } else if ($(this).children().css('backgroundImage') !== 'none') {
            $('.picture img').attr('src', $(this).children().css('backgroundImage').split('"')[1])
            $('.picture img').on('load', function () {
                $('.shade').show(0)
            })
        }
    }
})
