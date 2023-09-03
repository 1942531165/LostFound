document.write('<script src="/lostfound/js/all/all.js"></script>')
$(function () {
    // 点击左侧的管理会更新total
    let target = 'user-list'
    $('.tab-list').click(function () {
        // 修改target
        target = $('.data-form').eq($(this).index()).attr('id')
    })

    // 点击确定按钮或者背景可以关闭
    $('.shade').on('click', '.decide, .shadow, .edit-cancel', function (e) {
        e.preventDefault()
        $('.shade').fadeOut(200, function () {
            $('.datas').children().remove()
            $(document).unbind('scroll.unable')
        })
    })

    // 点击全选的时候，将所有checkbox都选中
    $('.select-all input').click(function () {
        // 判断 select_all 是否是全选状态
        let flag = $(this).parents('.checks').find('.select-all input').prop('checked')
        let inputs = $(this).parents('.checks').find('.data input[type="checkbox"]:not(:disabled)')
        if (flag) {
            // 找到所有可以选中的checkbox
            for (let i = 0; i < inputs.length; i++) {
                inputs.eq(i).prop('checked', 'checked')
                num = inputs.length
            }
        } else {
            for (let i = 0; i < inputs.length; i++) {
                inputs.eq(i).prop('checked', '')
                num = 0
            }
        }
    })
    // 如果逐个点击，点满了所有的checkbox后，依然会显示全选
    // 创建一个变量判断是否全部 checked
    let num = 0,
        len = 0
    $('.checks').on('click', '.data', function (e) {
        // 防止点击到 .data 里面的 checkbox
        if (!$(e.target).is('input')) {
            // 为了方便点击 input
            if ($(this).find('input[type="checkbox"]:not(:disabled)').prop('checked')) {
                $(this).find('input[type="checkbox"]:not(:disabled)').prop('checked', '')
            } else {
                $(this).find('input[type="checkbox"]:not(:disabled)').prop('checked', 'checked')
            }
        }
        target = $(this).parents('.data-form').attr('id')
        // 获取所有可以选中的 checkbox
        // 获取有多少个多选框
        len = $(`#${target} .data`).find('input[type="checkbox"]:not(:disabled)').length
        // 获取已经选中了多少个多选框
        num = $(`#${target} .data`).find('input[type="checkbox"]:not(:disabled)').filter(':checked').length
        if (len == num && len !== 0) {
            $(`#${target} .select-all input`).prop('checked', 'checked')
        } else {
            $(`#${target} .select-all input`).prop('checked', '')
        }
    })

    // 点击按钮关闭
    $('.floating-shade').on('click', '.cancel, .shadow', function () {
        $('.floating-shade').fadeOut(200)
    })

    // 删除
    // 创建一个数组来存储 获取的 Ids
    let selectedIds = []
    let state = ''
    let form = ''
    $('.del-btn').click(function () {
        state = 'delete'
        form = 'delete'
        selectedIds = getChecks(
            selectedIds,
            target,
            '删除之后不可复原',
            '你确定要<strong class="mdui-text-color-red-a700">删除</strong>选中的用户吗？',
            '你确定要<strong class="mdui-text-color-red-a700">删除</strong>选中的帖子吗？'
        )
    })

    // 审核
    // 过审
    $('.verified').click(function () {
        state = 'verified'
        form = 'audit'
        selectedIds = getChecks(
            selectedIds,
            target,
            '请谨慎审核',
            '你确定让选中的用户<strong class="mdui-text-color-indigo">通过审核</strong>吗？',
            '你确定让选中的帖子<strong class="mdui-text-color-indigo">通过审核</strong>吗？'
        )
    })
    // 不过审
    $('.unverified').click(function () {
        state = 'unverified'
        form = 'audit'
        selectedIds = getChecks(
            selectedIds,
            target,
            '请谨慎审核',
            '你确定让选中的用户<strong class="mdui-text-color-red-a700">不通过审核</strong>吗？',
            '你确定让选中的帖子<strong class="mdui-text-color-red-a700">不通过审核</strong>吗？'
        )
    })
    // 归还
    // 确认归还
    $('.returned').click(function () {
        state = 'returned'
        form = 'return'
        selectedIds = getChecks(selectedIds, target, '', '', '你确定选中的帖子<strong class="mdui-text-color-indigo">已经成功归还</strong>了吗？')
    })
    // 仍未归还
    $('.unreturned').click(function () {
        state = 'unreturned'
        form = 'return'
        selectedIds = getChecks(selectedIds, target, '', '', '你确定选中的帖子<strong class="mdui-text-color-red-a700">尚未成功归还</strong>吗？')
    })

    // 点击确定按钮
    $('.confirm').on('click', function () {
        loading()
        let formData = new FormData()
        // 放入 选中的id
        formData.append('ids', selectedIds)
        // 放入当前的 库
        formData.append('target', target)
        // 放入当前的 操作
        formData.append('form', form)
        if (form == 'audit') {
            // 审核 为1则审核通过，否则审核不通过
            state == 'verified' ? formData.append('audit', 1) : formData.append('audit', 2)
        } else if (form == 'return') {
            // 归还
            state == 'returned' ? formData.append('result', 1) : formData.append('result', 0)
        }
        $.ajax({
            url: `/lostfound/controller/admin-btns.php`,
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            datatype: 'json',
            success: function (jsondata) {
                let data = JSON.parse(jsondata)
                let msg = ''
                if (data.success == true) {
                    if (form == 'delete') {
                        // 删除
                        msg = data.count + ' 条数据删除完成，点击以关闭'
                    } else if (form == 'audit') {
                        // 审核
                        msg = data.count + ' 条数据审核完成，点击以关闭'
                    } else {
                        // 归还
                        msg = data.count + ' 条数据修改状态完成，点击以关闭'
                    }
                } else {
                    if (form == 'delete') {
                        // 删除
                        msg = '删除失败，还有 ' + data.count + ' 条数据未删除，点击以关闭'
                    } else if (form == 'audit') {
                        // 审核
                        msg = '审核失败，还有 ' + data.count + ' 条数据未审核，点击以关闭'
                    } else {
                        // 归还
                        msg = '修改失败，还有 ' + data.count + ' 条数据未修改，点击以关闭'
                    }
                }
                mdui.snackbar({
                    message: msg,
                    position: 'top',
                })
                unloading()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // 处理请求失败的情况
                mdui.snackbar({
                    message: '未搜寻到结果',
                    position: 'top',
                })
                unloading()
            },
        })
    })
})
function getChecks(selectedIds, target, tip, user_str, report_str) {
    // 每次先清空
    selectedIds = []
    // 先获取当前管理的表
    // 获取该库所有已经选中的 id
    let index, id, ids, head

    // 是否为 用户表
    if (target == 'user-list' || target == 'user-audit') {
        ids = $(`#${target} .uid div`)
        head = user_str
    } else {
        ids = $(`#${target} .id div`)
        head = report_str
    }

    let inputs = $(`#${target} .data`).find('input[type="checkbox"]:not(:disabled)')
    let len = $(`#${target} .data`).find('input[type="checkbox"]:not(:disabled)').length

    for (let i = 0; i < len; i++) {
        if (inputs.eq(i).prop('checked') == true) {
            // 将被选中的值放入 index 中，然后获取 id
            index = inputs.eq(i).parents('.data').index()
            // 获取当前的 id
            id = ids.eq(index).text()
            // 将选中的 id 添加到数组中
            selectedIds.push(id)
        }
    }
    // 如果 selectIds 有值 则弹出一个框， 警告管理员是否确定
    if (selectedIds.length > 0) {
        $(`.floating-shade`).fadeIn(200)
        $(`.warn-head`).html(head)
        $(`.warn-tip`).html(tip)
    }
    return selectedIds
}
