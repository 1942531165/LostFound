$(function () {
    // textarea高度自适应
    $('textarea').on('input', function () {
        this.style.height = 'auto'
        this.style.height = this.scrollHeight + 'px'
    })
})
