// 手机样子
function basic_m(data, nickname, i) {
    let state = ''
    if (data[i].state == '丢失物品') {
        state = `<div class="simple-lost">${data[i].state}</div>`
    } else if (data[i].state == '捡到物品') {
        state = `<div class="simple-found">${data[i].state}</div>`
    }
    let card_box = $(`
        <div class="simple-box" num="${data[i].id}">
            <div class="left"></div>
            <div class="right">
                <div class="simple-head">
                    <div class="simple-name">${nickname}</div>
                    ${state}
                </div>
                <div class="simple-title">${data[i].troduce}</div>
                <div class="simple-report-time">${data[i].create_time}</div>
            </div>
        </div>
    `)

    return card_box
}
// 基本样子
function basic(data, nickname, i) {
    let state = '',
        item_state = '',
        real_name_state = '',
        // 如果发表人没有写， 那么就不显示
        place = '',
        time = '',
        real_name = '',
        grades = ''
    if (data[i].state == '丢失物品') {
        state = `<div class="lost state">${data[i].state}</div>`
        // item_state = '丢失'
        real_name_state = '失主'
    } else if (data[i].state == '捡到物品') {
        state = `<div class="found state">${data[i].state}</div>`
        // item_state = '拾获'
        real_name_state = '拾获人'
    }
    // 如果发表人没有写， 那么就不显示
    if (data[i].address !== '') {
        place = `<div class="place">${item_state}地点<span>${data[i].address}</span><br></div>`
    }
    if (data[i].time !== '') {
        time = `<div class="time">${item_state}时间<span>${data[i].time}</span><br></div>`
    }
    if (data[i].real_name !== '') {
        real_name = `<div class="real_name">${real_name_state}姓名<span>${data[i].real_name}</span><br></div>`
    }
    if (data[i].grades !== '') {
        grades = `<div class="class">所在班级<span>${data[i].grades}</span><br></div>`
    }

    let card_box = $(
        `<div class="card-box" num="${data[i].id}">
        <div class="mdui-card mdui-shadow-i">
            <div class="mdui-card-header mdui-color-grey-300 card-head">
                <div class="head"></div>
                <div class="name">${nickname}</div>
                <div class="right">
                    <div class="report-time">${data[i].create_time}</div>
                    ${state}
                </div>
            </div>
            <div class="mdui-card-content card-body">
                <div class="title">${data[i].troduce}</div>
                <div class="msg">
                    <br>
                    ${place}
                    ${time}
                    <div class="info">详细信息<span>${data[i].info}</span><br></div>
                    ${real_name}
                    ${grades}
                    <div class="call">联系方式<span>${data[i].contact}</span><br></div>
                </div>
            </div>
            <div class="switch">
                <span class="switch-open more-info">展开<i class="mdui-icon material-icons">keyboard_arrow_down</i></span>
                <span class="switch-close">收起<i class="mdui-icon material-icons">keyboard_arrow_up</i></span>
            </div>
            <div class="image-box">
                <div></div>
            </div>
        </div>
    </div>`
    )

    return card_box
}
