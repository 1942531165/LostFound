// 获取index 和 id
function gets(that, target) {
    let index = that.parents('.data').index()
    // 通过index获取id
    let id = 0
    if (target == '#user-list' || target == '#user-audit') {
        id = $(target).find('.uid div').eq(index).text()
    } else {
        id = $(target).find('.id div').eq(index).text()
    }
    return id
}
// 禁止滚动条进行滚动
function disable_scroll() {
    // 禁止滚动条进行滚动
    let top = $(document).scrollTop()
    $(document).on('scroll.unable', function (e) {
        $(document).scrollTop(top)
    })
}
