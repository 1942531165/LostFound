document.write('<script src="/lostfound/js/all/all.js"></script>')
// 定义为全局变量
let row, image, head, nickname, stop
let maxCount = 12,
    minCount = 0,
    inscrease = 12
// 获取数据
$(function () {
    // 搜索部分
    // 如果放入了关键词，那么就进行搜索
    // 创建一个关键词变量
    // 空关键词表示没有关键词
    let keyword = ''
    // 创建一个 state 变量来存放 选择的 radio
    let state = 'all'
    // 焦点离开input框时更新关键词
    $('.search-input input').on('change', function () {
        // console.log('你写了关键词！')
        // 将数据传出数据库， 并返回数据库符合关键词的信息
        keyword = $(this)[0].value
        // console.log(keyword)
    })
    // 回车触发搜索
    $('.search-input input').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            // console.log('你按下了回车！')
            search(keyword, state)
        }
    })
    // 点击按钮也能触发搜索
    $('.search-btn').on('click', function () {
        // console.log('点击了按钮!')
        // console.log(keyword, '关键词是...')
        search(keyword, state)
    })
    // 如果点击筛选，那么就先获取搜索框的内容
    $('.radio input, .tab a').on('click', function () {
        if ($(this).attr('id') == 'group1' || $(this).attr('check') == 'group1') {
            state = 'all'
        } else if ($(this).attr('id') == 'group2' || $(this).attr('check') == 'group2') {
            state = 'lost'
        } else if ($(this).attr('id') == 'group3' || $(this).attr('check') == 'group3') {
            state = 'found'
        }
        // 点击时就相当于触发了 搜索
        search(keyword, state)
    })

    // home页面的数据
    let check
    if (location.href.indexOf('home') !== -1) {
        check = 0
    } else {
        check = 1
    }
    if (check == 0) {
        loading()
        $.ajax({
            url: '/lostfound/controller/get-data.php',
            type: 'POST',
            data: { check: check },
            dataType: 'json',
            success: function (data) {
                if (data.row.length > 0) {
                    row = data.row
                    image = data.image
                    head = data.head
                    nickname = data.nickname
                    // 放数据
                    stop = row.length
                    // 默认显示部分数据
                    putData(row, image, head, nickname, maxCount, minCount, stop)
                    if (data.row.length > inscrease) {
                        $('.footer').addClass('show')
                    }
                } else {
                    $('.warn').show(0)
                }
                unloading()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error: ' + textStatus + ' - ' + errorThrown)
                unloading()
            },
        })
        // 点击查看更多
        $('.more').click(function () {
            // 顺便判断 搜索栏
            if (minCount < stop) {
                maxCount += inscrease
                minCount += inscrease
                putData(row, image, head, nickname, maxCount, minCount, stop)
            }
        })
    } else {
        // publish页面的数据
        $.ajax({
            url: '/lostfound/controller/get-data.php',
            type: 'POST',
            data: { check: check },
            dataType: 'json',
            success: function (data) {
                // console.log(data)
                row = data.row
                image = data.image
                head = data.head
                nickname = data.nickname
                if (row.length == 0 || image.length == 0) {
                    $('.no-report').show(0)
                    return true
                }
                // 放数据
                // PC的数据
                if ($(document).width() > 780) {
                    for (let i = 0; i < row.length; i++) {
                        let card_box = basic(row, nickname, i)
                        // 放数据
                        $('.card-list').append(card_box)
                        // 放图片
                        for (let j = 0; j < image[i].length; j++) {
                            let imageDiv = $(`<div class="image" style="background: url('${image[i][j]}') center center / cover no-repeat;"></div>`)
                            $('.image-box>div')[i].append(imageDiv[0])
                        }
                        // 放头像
                        $('.card-box .head')[i].style.background = `url(${head}) center center / cover no-repeat`
                    }
                } else {
                    // 手机版没有头像
                    for (let i = 0; i < row.length; i++) {
                        let card_box = basic_m(row, nickname, i)
                        // 放数据
                        $('.simple-list').append(card_box)
                        // 放图片
                        if (image[i].length < 1) {
                            imageDiv = $(
                                `<div class="simple-img" style="background: url('/lostfound/asset/title.jpg') center center / cover no-repeat;"></div>`
                            )
                        } else {
                            imageDiv = $(`<div class="simple-img" style="background: url('${image[i][0]}') center center / cover no-repeat;"></div>`)
                        }
                        $('.left')[i].append(imageDiv[0])
                    }
                    // 调整手机上的shade
                }
                for (let i = 0; i < row.length; i++) {
                    // 增加一个 success 和一个 success_logo 的变量
                    let success = $('<div class="success-shade"><img src="/lostfound/asset/success.png"><span>成功寻回</span></div>')
                    let edit = $(
                        `<div class="edit-shade"><button class="edit-btn mdui-btn mdui-btn-raised mdui-color-red-indigo">修改该信息</button></div>`
                    )
                    let del = $(
                        `<div class="del-shade"><button class="del-btn mdui-btn mdui-btn-raised mdui-color-red-a700">删除该信息</button></div>`
                    )
                    let audit = $(`<div class="audit-shade"><img src="/lostfound/asset/error.png"><span>未通过审核<br/>请重新修改信息</span></div>`)
                    let auditing = $(
                        `<div class="auditing-shade"><img src="/lostfound/asset/auditing.png"><span>正在审核中<br/>请耐心等待</span></div>`
                    )
                    let success_logo = ''
                    if (row[i].success_time == '尚未归还') {
                        success_logo = $(`<div class="footer"><div></div><span>${row[i].success_time}</span></div>`)
                    } else {
                        $('.card-box, .simple-box').eq(i).addClass('success')
                        success_logo = $(`<div class="footer"><div>归还日期：${row[i].success_time}</div><span>成功归还</span></div></div>`)
                    }
                    // 放入 mdui-card 当中
                    // 默认拥有修改和删除的按钮操作
                    $('.mdui-card, .simple-box').eq(i).prepend(del[0])
                    $('.mdui-card, .simple-box').eq(i).prepend(edit[0])
                    // 如果成功归还了，那么显示成功
                    if (row[i]['success_time'] !== '尚未归还') {
                        $('.mdui-card, .simple-box').eq(i).prepend(success[0])
                        $('.mdui-card').eq(i).append(success_logo[0])
                    } else {
                        $('.mdui-card').eq(i).append(success_logo[0])
                    }
                    if (row[i]['audit'] == 2) {
                        $('.card-box, .simple-box').eq(i).addClass('audit')
                        $('.mdui-card, .simple-box').eq(i).prepend(audit[0])
                    } else if (row[i]['audit'] == 0) {
                        $('.card-box, .simple-box').eq(i).addClass('auditing')
                        $('.mdui-card, .simple-box').eq(i).prepend(auditing[0])
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error: ' + textStatus + ' - ' + errorThrown)
            },
        })
    }

    // 点击 simple-box 的时候获取 id 并跳转到手机页面， 显示该信息的详细
    $('.simple-list').on('click', '.simple-box', function () {
        if (check == 0) {
            let index = $(this).attr('num')
            // 将 index 记录到 SESSION 中，然后跳转到 phone_info 来显示详情
            $.ajax({
                url: '/lostfound/controller/save-index.php',
                method: 'POST',
                data: { index: index },
                success: function (data) {
                    if (data == 'success') {
                        // 跳转到 phone_info
                        window.location.href = '/lostfound/view/phone_info.php'
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // 处理请求失败的情况
                    console.log(errorThrown)
                },
            })
        }
    })
})
function search(keyword, check) {
    // 将显示变为初始值
    maxCount = 3
    minCount = 0
    // 将显示更多按钮显示
    $('.footer').show(0)
    $.ajax({
        url: '/lostfound/controller/search.php',
        method: 'POST',
        dataType: 'json',
        data: { keyword: keyword },
        success: function (data) {
            row = data.row
            image = data.image
            head = data.head
            nickname = data.nickname
            // 判断下面的三个按钮
            // 如果按下的是全部，则跳过这个步骤
            // 如果是 只看失物 或者 只看寻物， 则获取符合条件的内容
            if (check == 'lost') {
                // 获取丢失的物品
                for (let i = 0; i < row.length; i++) {
                    if (row[i]['state'] !== '丢失物品') {
                        row.splice(i, 1)
                        image.splice(i, 1)
                        head.splice(i, 1)
                        nickname.splice(i, 1)
                        i--
                    }
                }
            } else if (check == 'found') {
                // 获取捡到的物品
                for (let i = 0; i < row.length; i++) {
                    if (row[i]['state'] !== '捡到物品') {
                        row.splice(i, 1)
                        image.splice(i, 1)
                        head.splice(i, 1)
                        nickname.splice(i, 1)
                        i--
                    }
                }
            }
            stop = row.length
            updateData(row, image, head, nickname, stop, minCount, maxCount)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // 处理请求失败的情况
            console.log(errorThrown)
        },
    })
}
function updateData(row, image, head, nickname, stop, minCount, maxCount) {
    // 搜索完之后更新数据
    // 删除所有帖子
    // 先判断是手机还是PC
    if ($(document).width() > 780) {
        for (let i = 0; i < $('.card-box').length; i++) {
            if ($('.card-box').length > 0) {
                $('.card-box')[i].remove()
                i--
            }
        }
    } else {
        for (let i = 0; i < $('.simple-box').length; i++) {
            if ($('.simple-box').length > 0) {
                $('.simple-box')[i].remove()
                i--
            }
        }
    }
    // 将获取的数据变成新的帖子
    // 判断停止处
    putData(row, image, head, nickname, maxCount, minCount, stop)
}
function putData(row, image, head, nickname, maxCount, minCount, stop) {
    // 判断停止处
    let flag = true
    for (minCount; minCount < maxCount; minCount++) {
        // 如果 未满 stop 但是并没有下一条信息了
        if (minCount > stop - 1) {
            break
        }
        if ($(document).width() > 780) {
            // 判断是否是手机的屏幕
            let card_box = basic(row, nickname[minCount], minCount)
            // 放数据
            $('.card-list').append(card_box)
            // 放图片
            for (let j = 0; j < image[minCount].length; j++) {
                let imageDiv = $(`<div class="image" style="background: url('${image[minCount][j]}') center center / cover no-repeat;"></div>`)
                $('.image-box>div')[minCount].append(imageDiv[0])
            }
            // 放头像
            $('.card-box .head')
                .eq(minCount)
                .css({
                    background: `url(${head[minCount]}) center center / cover no-repeat`,
                })
        } else {
            let card_box = basic_m(row, nickname[minCount], minCount)
            $('.simple-list').append(card_box)
            let imageDiv
            if (image[minCount].length < 1) {
                imageDiv = $(`<div class="simple-img" style="background: url('/lostfound/asset/title.jpg') center center / cover no-repeat;"></div>`)
            } else {
                imageDiv = $(`<div class="simple-img" style="background: url('${image[minCount][0]}') center center / cover no-repeat;"></div>`)
            }
            $('.left')[minCount].append(imageDiv[0])
        }
    }
    // 如果到底了
    if (minCount > stop - 1) {
        flag = false
    }
    if (!flag) {
        mdui.snackbar({
            message: '没有更多数据了。',
            position: 'bottom',
            timeout: '1000',
        })
        $('.footer').hide(0)
    }
}
