document.write('<script src="/lostfound/js/all/all.js"></script>')
let maxCount = 50,
    minCount = 0,
    inscrease = 50
// 点击 上一页 下一页 切换 页码， 点击页码也可以切换页码
let pageIndex = 0
let p_num = 1
// 当前选中库的数据
let dataTemp
$(function () {
    // 创建一个用户管理数组
    let user_datas = ['uid', 'account', 'nickname', 'class', 'serial', 'contact', 'role']
    // 创建一个失物招领管理和寻物启事管理的数组
    let report_datas = ['id', 'troduce', 'info', 'contact', 'result']
    // 创建一个帖子管理数组
    let report_all_data = ['id', 'troduce', 'info', 'contact', 'result', 'state']
    // 创建一个用户审核数据
    let user_audit = ['uid', 'account', 'nickname', 'contact', 'role', 'audit']
    // 创建一个帖子审核数据
    let report_audit = ['id', 'troduce', 'info', 'contact', 'state', 'audit']
    // 点击时显示数据
    // 设置一个默认的href，来获取搜索的表格
    let href = '#user-list'
    let datas = user_datas
    let target = 'user'
    getData(target, datas, href)
    // 显示的文字
    let screen = {
        target: ['user', 'report', 'lost', 'found', 'success', 'ua', 'ra'],
        audit: [true, true, true, true, true, false, false],
        text: ['用户数量：', '帖子数量：', '寻物启事数量：', '失物招领数量：', '成功案例数量：', '审核中的用户数量：', '审核中的帖子数量：'],
        zero: ['用户管理表', '帖子管理表', '寻物启事管理表', '失物招领管理表', '成功案例管理表', '用户审核管理表', '帖子审核管理表'],
    }
    // 和主页类似的关键词搜索
    let keyword = ''
    // 统计 默认显示的 user-list 的用户总数
    totalCount(screen.target[0], screen.audit[0], screen.text[0])
    // 点击左侧切换管理面板时
    $('.tab-list').on('click', function () {
        // 弹出加载
        loading()
        href = $(this).attr('href')
        switch (href) {
            case '#user-list':
                target = 'user'
                datas = user_datas
                break
            case '#report-list':
                target = 'report'
                datas = report_all_data
                break
            case '#lost-list':
                target = 'lost'
                datas = report_datas
                break
            case '#found-list':
                target = 'found'
                datas = report_datas
                break
            case '#success-list':
                target = 'success'
                datas = report_all_data
                break
            case '#user-audit':
                target = 'user-audit'
                datas = user_audit
                break
            case '#report-audit':
                target = 'report-audit'
                datas = report_audit
                break
        }
        getData(target, datas, href)
        // 统计数量
        index = $(this).index()
        totalCount(screen.target[index], screen.audit[index], screen.text[index])
        // minCount 和 maxCount 默认为 0
        minCount = 0
        maxCount = 50
        // 并将页面默认为 1
        pageIndex = 0
        p_num = 1
        // 清空 keyword
        keyword = ''
        $('.search input').val('')
        // 实时更新页码
        // 清空之前的页码
        $('.footer .pages .page').remove()

        // 右侧按钮
        let id = $('.data-form').eq(index).attr('id')
        if (id == 'user-audit' || id == 'report-audit') {
            // 显示审核按钮
            $('.audit-btn').show(0)
            // 确认归还按钮消失
            $('.return-btn').hide(0)
            // 删除按钮不可用
            $('.del-btn').prop('disabled', true)
        } else if (id == 'user-list' || id == 'success-list') {
            // 如果是用户 或者 成功案例， 那么只剩下最初的两个按钮
            $('.special-btn').hide(0)
            // 显示归还
            $('.return-btn').show(0)
            // 删除按钮可用
            $('.del-btn').prop('disabled', false)
        } else {
            // 如果是 帖子管理、失物招领管理、寻物启事管理 那么显示 归还按钮
            // 审核按钮消失
            $('.audit-btn').hide(0)
            // 显示归还按钮
            $('.return-btn').show(0)
            // 删除按钮可用
            $('.del-btn').prop('disabled', false)
        }
    })
    // 搜索功能
    // 先判断点击的是哪一个管理
    $('.search input').on('change', function () {
        keyword = $(this)[0].value
    })
    // 回车触发搜索
    $('.search input').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            search(keyword)
        }
    })
    // 点击按钮也能触发搜索
    $('.search-btn').on('click', function () {
        search(keyword)
    })
    // 创建两个变量 第一个变量 为 pageIndex - 5, 另外一个为 pageIndex + 4
    let pageStart = p_num - 5
    let pageEnd = p_num + 4
    $('.footer').on('click', '.page', function () {
        pageIndex = $(this).index()
        // 获取点击的页码
        p_num = $(this).attr('page')
        // 将 page="p_num" 的 .page 选中
        $(this).addClass('select').siblings().removeClass('select')
        pageBtns(p_num)
        showPages(pageStart, pageEnd)
        // 更新数据
        pageData(p_num)
    })
    let btnId
    $('.page-btn').click(function () {
        btnId = $(this).attr('id')
        if (btnId == 'n-page' && p_num < $('.page').length) {
            pageIndex++
            p_num++
        } else if (btnId == 'p-page' && p_num > 1) {
            pageIndex--
            p_num--
        }
        $('.page').eq(pageIndex).addClass('select').siblings().removeClass('select')
        pageBtns(p_num)
        showPages(pageStart, pageEnd)
        // 更新数据
        pageData(p_num)
    })
    // 如果按钮在第一页或是最后一页，则上一页或者下一页按钮消失
    function pageBtns(p_num) {
        // 判断是否只有一页
        if ($('.footer .pages .page').length > 1) {
            $('.pages').css('margin', '0 10px')
            if (p_num == 1) {
                $('#p-page').hide(0)
                $('.pages').css('marginLeft', '90px')
                $('#n-page').show(0)
            } else if (p_num == $('.page').length) {
                $('#n-page').hide(0)
                $('.pages').css('marginRight', '90px')
                $('#p-page').show(0)
            } else {
                $('#p-page').show(0)
                $('#n-page').show(0)
            }
        } else {
            $('#p-page').hide(0)
            $('.pages').css('marginLeft', '90px')
            $('#n-page').hide(0)
        }
    }
    // 显示指定范围的页码
    function showPages(start, end) {
        end = p_num + 4
        start = p_num - 5
        // 隐藏所有页码
        $('.page').hide(0)
        // 显示指定的页码
        end = end <= 10 ? 10 : end
        if (end >= $('.page').length) {
            end = $('.page').length
            start = end - 9
        }
        // console.log(start, end, 'next', p_num)
        for (let i = start; i <= end; i++) {
            if (i <= 0) {
                continue
            }
            if (
                $('.page')
                    .eq(i - 1)
                    .attr('page') == i
            ) {
                $('.page')
                    .eq(i - 1)
                    .show(0)
            }
        }
    }
    // 点击页码或者上一页下一页的时候显示该页码的数据
    function pageData(p_num) {
        maxCount = p_num * inscrease
        minCount = maxCount - inscrease
        // 清空数据并重新放入
        // 先确认目前显示的是哪一个管理库
        $(`${href} .data`).remove()
        // 放入新的数据
        putData(dataTemp, datas, href)
        // 判断目前查看的表格
        ToWord(href)
    }
    // 搜索函数
    function search(keyword) {
        // 搜索的时候 minCount 和 maxCount 也要变成 0
        minCount = 0
        maxCount = 12
        // 获取目前查看的是什么管理
        // 用户表和其他表是分开的，需要单独判断是否为用户表
        let formData = new FormData()
        formData.append('keyword', keyword)
        formData.append('state', target)
        // for (let [a, b] of formData.entries()) {
        //     console.log(a, b, '--------------')
        // }
        searching(formData, href)
    }
    // 开始搜索
    function searching(formData, href) {
        $.ajax({
            url: '/lostfound/controller/admin-search.php',
            method: 'POST',
            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                // 放入新数据
                put(data, datas, href)
            },
            error: function () {
                // 处理请求失败的情况
                mdui.snackbar({
                    message: '未搜寻到结果',
                    position: 'top',
                })
            },
        })
    }
    // 获取数量
    function totalCount(target, audit, msg) {
        $.ajax({
            url: '/lostfound/controller/admin-total.php',
            type: 'POST',
            data: { target: target, audit: audit },
            success: function (data) {
                $('.total').children().remove()
                $('.total').append($(`<h4>${msg}<span>${data}</span></h4>`))
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText)
            },
        })
    }
    // 获取帖子
    function getData(target, datas, f) {
        // 放入页码
        $.ajax({
            url: '/lostfound/controller/admin-get.php',
            type: 'POST',
            dataType: 'JSON',
            data: { state: target },
            success: function (data) {
                if (data.length > 0) {
                    $(`${f} .list`).show(0)
                    $(`${f} .tips`).remove()
                    dataTemp = data
                    // 放入视图
                    put(data, datas, f)
                    // 将 全选 关闭
                    $(`${f} #report-all`).attr('checked', false)
                } else {
                    $(`${f} .list`).hide(0)
                    $(`${f} .tips`).remove()
                    $(`${f}`).append(`<h2 class="tips">${screen.zero[index]} 目前尚没有数据</h2>`)
                }
                unloading()
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText)
            },
        })
    }
    // 放数据
    function put(data, data_, target) {
        // 清空用户表，显示获取到的数据
        $(`${target} .data`).remove()
        // 清空之前的页码
        $('.footer .pages .page').remove()
        // 放入页码
        let len = Math.ceil(data.length / maxCount)
        for (let page = 1; page <= len; page++) {
            if (page == 1) {
                $('.footer .pages').append($(`<div class="page select" page="${page}">${page}</div>`))
            } else {
                $('.footer .pages').append($(`<div class="page" page="${page}">${page}</div>`))
            }
        }
        // 判断页码的页数
        pageBtns(p_num)
        // 放入数据
        putData(data, data_, target)
        // 判断目前查看的表格
        ToWord(target)
        unloading()
    }
    function putData(data, data_, target) {
        // 放入数据
        // 放数据的时候根据 maxCount 和 minCount 来
        for (minCount; minCount < maxCount; minCount++) {
            if (minCount >= data.length) {
                // 超过就结束
                break
            }
            if (target !== '#user-list' || target !== '#user-audit') {
                $(`${target} .list .checks`).append($(`<div class="data"><input type="checkbox" value="${data[minCount]['id']}"></div>`))
            } else {
                $(`${target} .list .checks`).append($(`<div class="data"><input type="checkbox" value="${data[minCount]['uid']}"></div>`))
            }
            // 放入方框
            if (target !== '#success-list') {
                $(`${target} .list .edit`).append(
                    $(
                        `<div class="data btns">
                        <button class="mdui-btn mdui-btn-raised mdui-color-indigo read-btn">查看</button>
                        <button class="mdui-btn mdui-btn-raised mdui-color-indigo edit-btn">修改</button>
                        </div>`
                    )[0]
                )
            } else {
                $(`${target} .list .edit`).append(
                    $(
                        `<div class="data btns">
                        <button class="mdui-btn mdui-btn-raised mdui-color-indigo read-btn">查看</button>
                        </div>`
                    )[0]
                )
            }
            for (let j = 0; j < data_.length; j++) {
                if (data[minCount][data_[j]] == '') {
                    data[minCount][data_[j]] = '未填写'
                }
                // 放入数据
                $(`${target} .list li`)[j + 1].append($(`<div class="data">${data[minCount][data_[j]]}</div>`)[0])
            }
        }
    }
    // 数据转文字
    function ToWord(reports) {
        let len = $(`${reports} .list li`).length
        let lis = $(`${reports} .list li`)
        if (reports == '#user-list') {
            adminCheckbox(len, lis, reports)
        } else if (reports == '#user-audit' || reports == '#reports-audit') {
            change(len, lis, 'audit', 'pass', 'under', '审核通过', '审核中...')
            if (reports == '#user-audit') {
                adminCheckbox(len, lis, reports)
            }
        } else {
            change(len, lis, 'result', 'success', 'unfinish', '已归还', '归还中...')
            change(len, lis, 'audit', 'pass', 'under', '审核通过', '审核中...')
        }
    }
    function adminCheckbox(len, lis, reports) {
        for (let i = 0; i < len; i++) {
            if (lis[i].getAttribute('class') == 'role') {
                // 获取子元素的长度和子元素
                let div_len = lis[i].children.length
                let divs = lis[i].children
                for (let j = 1; j < div_len; j++) {
                    if (divs[j].innerHTML == 1) {
                        divs[j].innerHTML = '管理员'
                        $(`${reports}`).find('.checks input').eq(j).prop({ disabled: true, title: '管理员无法被删除' })
                    } else {
                        divs[j].innerHTML = '普通用户'
                    }
                }
            }
        }
    }
    function change(len, lis, target, class1, class2, word1, word2) {
        for (let i = 0; i < len; i++) {
            if (lis[i].getAttribute('class') == target) {
                let div_len = lis[i].children.length
                let divs = lis[i].children
                for (let j = 1; j < div_len; j++) {
                    if (divs[j].innerHTML == 1) {
                        divs[j].classList.add(class1)
                        divs[j].innerHTML = word1
                    } else {
                        divs[j].classList.add(class2)
                        divs[j].innerHTML = word2
                    }
                }
            }
        }
    }
})
