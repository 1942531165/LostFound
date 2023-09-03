document.write('<script src="/lostfound/js/all/all.js"></script>')
document.write('<script src="/lostfound/js/admin/admin-all.js"></script>')
$(function () {
    // 点击“查看”可以看到详细信息
    const readEle = [
        { selector: '#user-list', url: 'admin-read-user.php' },
        { selector: '#report-list', url: 'admin-read-report.php' },
        { selector: '#lost-list', url: 'admin-read-report.php' },
        { selector: '#found-list', url: 'admin-read-report.php' },
        { selector: '#success-list', url: 'admin-read-report.php' },
        { selector: '#user-audit', url: 'admin-read-user.php' },
        { selector: '#report-audit', url: 'admin-read-report.php' },
    ]
    readEle.forEach(function (readEle) {
        read(readEle.url, readEle.selector)
    })

    // 查看数据
    function read(url, target) {
        // 点击“查看”按钮查看详情
        $(target).on('click', '.read-btn', function () {
            loading()
            id = gets($(this), target)
            $.ajax({
                url: `/lostfound/controller/${url}`,
                type: 'post',
                dataType: 'json',
                data: { id: id },
                success: function (data) {
                    let row = data.row[0]
                    let head = data.head
                    let nickname = data.nickname
                    let datas
                    // 禁止滚动条进行滚动
                    disable_scroll()
                    // 放入数据
                    let timeStamp = new Date().getTime()
                    if (target == '#user-list' || target == '#user-audit') {
                        let role = ''
                        if (row['role'] == 0) {
                            row['role'] = '普通用户'
                            role = 'user'
                        } else {
                            row['role'] = '管理员'
                            role = 'admin'
                        }
                        datas = $(
                            `<div class="user-data card-box">
                        <div class="mdui-card-header mdui-color-grey-300 card-head">
                            <div class="user-head" style="background: url('${head}?timestamp=${timeStamp}') center center / cover no-repeat;"></div>
                            <div class="nickname">${row['nickname']}</div>
                            <div class="right">
                                <div class="role ${role}">${row['role']}</div>
                            </div>
                        </div>
                        <div class="mdui-card-content card-body">
                            <div class="account">
                                <h4>账号</h4>
                                <span>${row['account']}</span>
                            </div>
                            <div class="password">
                                <h4>密码</h4>
                                <span>${row['password']}</span>
                            </div>
                            <div class="real_name">
                                <h4>真实姓名</h4>
                                <span>${row['real_name']}</span>
                            </div>
                            <div class="class">
                                <h4>班级</h4>
                                <span>${row['class']}</span>
                            </div>
                            <div class="serial">
                                <h4>学号</h4>
                                <span>${row['serial']}</span>
                            </div>
                            <div class="contact">
                                <h4>联系方式</h4>
                                <span>${row['contact']}</span>
                            </div>
                            <div class="email">
                                <h4>邮箱</h4>
                                <span>${row['email']}</span>
                            </div>
                            <div class="create-time">
                                <h4>创建时间</h4>
                                <span>${row['create_time']}</span>
                            </div>
                            <button class="mdui-btn mdui-btn-raised mdui-color-indigo decide">确定</button>
                        </div>
                    </div>`
                        )
                    } else {
                        let state = ''
                        if (row['state'] == '丢失物品') {
                            state = 'lost'
                        } else if (row['state'] == '捡到物品') {
                            state = 'found'
                        }
                        datas = $(
                            `<div class="report-data card-box">
                                <div class="mdui-card mdui-shadow-i">
                                    <div class="mdui-card-header mdui-color-grey-300 card-head">
                                        <div class="user-head" style="background: url('${head}?timestamp=${timeStamp}') center center / cover no-repeat;"></div>
                                        <div class="nickname">${nickname}</div>
                                        <div class="right">
                                            <div class="report-time">${row.create_time}</div>
                                            <div class="state ${state}">${row.state}</div>
                                        </div>
                                    </div>
                                    <div class="mdui-card-content card-body">
                                        <div class="troduce">${row.troduce}</div>
                                        <div class="address">
                                            <h4>地点</h4>
                                            <span>${row.address == '' ? '未填写' : row.address}</span>
                                        </div>
                                        <div class="time">
                                            <h4>时间</h4>
                                            <span>${row.time == '' ? '未填写' : row.time}</span>
                                        </div>
                                        <div class="info">
                                            <h4>详细信息</h4>
                                            <span>${row.info}</span>
                                        </div>
                                        <div class="real_name">
                                            <h4>发布人姓名</h4>
                                            <span>${row.real_name == '' ? '未填写' : row.real_name}</span>
                                        </div>
                                        <div class="grades">
                                            <h4>发布人班级</h4>
                                            <span>${row.grades == '' ? '未填写' : row.grades}</span>
                                        </div>
                                        <div class="contact">
                                            <h4>联系方式</h4>
                                            <span>${row.contact}</span>
                                        </div>
                                    </div>
                                    <button class="mdui-btn mdui-btn-raised mdui-color-indigo decide">确定</button>
                                </div>
                            </div>`
                        )
                    }
                    // 清除上一次的记录
                    $('.datas').children().remove()
                    // 写入
                    $('.datas').append(datas)
                    // 如果是report，则放入图片
                    if (target !== '#user-list' && target !== '#user-audit') {
                        let image = data.image
                        if (image.length !== 0) {
                            $('.datas').append(
                                $(`<div class="image-box">
                            <div class="image-list"></div>
                            </div>`)
                            )
                            for (let i = 0; i < image.length; i++) {
                                $('.image-list').append(
                                    $(`<div class="image" style="background: url('${image[i]}') center center / cover no-repeat;"></div>`)
                                )
                            }
                        }
                    }
                    unloading()
                    // 显示 shade
                    $('.shade').fadeIn(200)
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText)
                },
            })
        })
    }
})
