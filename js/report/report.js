document.write('<script src="/lostfound/js/report/image-upload.js"></script>')
document.write('<script src="/lostfound/js/all/all.js"></script>')
$(function () {
    let imgList = []
    $('.files').on('change', function () {
        for (let i = 0; i < $(this)[0].files.length; i++) {
            let size = $(this)[0].files[i].size
            if (size <= 10 * 1024 * 1024) {
                imgList.unshift($(this)[0].files[i])
            }
        }
    })
    $('.upload-box').on('click', '.delete', function () {
        let index = $(this).parent().parent().index()
        imgList.splice(index, 1)
    })
    $('.upload-lost').one('submit', function (event) {
        loading()
        event.preventDefault()
        $('.publish-btn').prop('disabled', true)
        let formData
        let state = '丢失物品'
        formData = pickInfo(state, $('.upload-lost'), imgList)
        upload_info(formData, '/lostfound/controller/upload.php', '/lostfound/view/home.php', false)
    })
    $('.upload-found').one('submit', function (event) {
        loading()
        event.preventDefault()
        $('.publish-btn').prop('disabled', true)
        let formData
        let state = '捡到物品'
        formData = pickInfo(state, $('.upload-found'), imgList)
        upload_info(formData, '/lostfound/controller/upload.php', '/lostfound/view/home.php', false)
    })
})
