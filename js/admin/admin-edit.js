document.write('<script src="/lostfound/js/all/all.js"></script>')
document.write('<script src="/lostfound/js/admin/admin-all.js"></script>')
$(function () {
    let imgNum = 0
    let imgList = []
    let oldImg = []
    let newImg = []
    let state = ''
    let formData

    const editEle = [
        { selector: '#user-list', getUrl: 'admin-read-user.php', oldImg: oldImg, newImg: newImg },
        { selector: '#report-list', getUrl: 'admin-read-report.php', oldImg: oldImg, newImg: newImg },
        { selector: '#lost-list', getUrl: 'admin-read-report.php', oldImg: oldImg, newImg: newImg },
        { selector: '#found-list', getUrl: 'admin-read-report.php', oldImg: oldImg, newImg: newImg },
        { selector: '#user-audit', getUrl: 'admin-read-user.php', oldImg: oldImg, newImg: newImg },
        { selector: '#report-audit', getUrl: 'admin-read-report.php', oldImg: oldImg, newImg: newImg },
    ]

    editEle.forEach(function (editEle) {
        edit(editEle.getUrl, editEle.selector, editEle.oldImg, editEle.newImg)
    })

    // 更新用户信息
    $('.datas').on('mouseenter', '.edit-user .user-heads', function () {
        $('.edit-user .head-shade').stop()
        $('.edit-user .head-shade').fadeIn(200)
    })
    $('.datas').on('mouseleave', '.edit-user .user-heads', function () {
        $('.edit-user .head-shade').stop()
        $('.edit-user .head-shade').fadeOut(200)
    })
    $('.datas').on('click', '.edit-user .head-shade', function () {
        $('.select-user_head').click()
    })
    // 更换新头像
    let img
    $('.datas').on('change', '.select-user_head', function () {
        loading()
        img = $(this)[0].files[0]
        // 创建一个 FileReader 对象，用于读取文件数据
        let reader = new FileReader()
        reader.readAsDataURL(img)
        // 替换路径
        // 当fileReader准备完毕后，替换地址
        reader.onload = function (e) {
            // 将图片元素的 src 属性设置为数据 URL
            $('.user-head').css('background', `url(${e.target.result}) center center / cover no-repeat`)
            unloading()
        }
    })
    // 判断是否修改过
    let userdata = []
    $('.datas').on('input change', '.edit-box input, .modify-role', function () {
        let modifyState = userdata[$(this)[0].classList[0]] !== $(this).val()
        $(this).attr('data-modify', modifyState)
    })
    // 开始更新用户数据
    $('.datas').on('submit', '.edit-user form', function (e) {
        e.preventDefault()
        // 使用formData为ajax传输数据
        let formData = new FormData()
        // 将修改过的数据记录到formData中
        $('input[data-modify="true"], select[data-modify="true"]').each(function () {
            formData.append($(this)[0].classList[0].replace('modify-', ''), $(this).val())
        })
        // 使用formData的entries来获取formData是否拥有数据
        let entry = formData.entries()
        // 如果没有数据，则无需使用ajax传输数据
        if (entry.next().done !== true) {
            // 需要修改，则获取uid
            formData.append('id', id)
            // 更改了头像
            if (img !== undefined) {
                formData.append('img', img)
            }
            $.ajax({
                url: '/lostfound/controller/admin-edit-user.php',
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    // console.log(response)
                    if (response == 'success') {
                        // 修改完资料， 需要将重新获取数据， 并修改页面
                        // 获取需要修改的资料
                        let updateUser = ['account', 'nickname', 'class', 'serial', 'contact', 'role']
                        for (let i = 0; i < updateUser.length; i++) {
                            if (formData.get(updateUser[i]) !== null) {
                                $(`#user-list .${updateUser[i]}`).children('.title, .data').eq(index).text(formData.get(updateUser[i]))
                            }
                        }
                        mdui.snackbar({
                            message: '修改用户资料成功',
                            position: 'top',
                            timeout: '1000',
                        })
                        unloading()
                        // 关闭 shade
                        $('.shadow').click()
                        // 换成新的头像
                        let head = $('.head')[0].style.backgroundImage.split('"')[1]
                        replace_head(img, id, head)
                    }
                },
                error: function (xhr, status, error) {
                    mdui.snackbar({
                        message: '修改失败，发生未知问题！',
                        position: 'top',
                        timeout: '1000',
                    })
                    unloading()
                    // 关闭 shade
                    $('.shadow').click()
                },
            })
        } else {
            mdui.snackbar({
                message: '您尚未做出任何修改',
                position: 'top',
                timeout: '1000',
            })
            unloading()
            // 关闭 shade
            $('.shadow').click()
        }
    })

    // 更新帖子信息
    // 点击按钮相当于提交更新数据
    $('.datas').on('click', '.edit-submit', function () {
        loading()
        // 相当于提交
        let form = $(this).closest('form')
        form.trigger('submit')
    })

    // 创建一个 formdata 来获取修改的数据和图片数据
    $('.datas').on('submit', '.edit-report form', function (e) {
        e.preventDefault()
        if ($(this).data('submitted')) {
            e.preventDefault() // 阻止表单提交
            return
        }
        $(this).data('submitted', true) // 添加提交标记
        loading()
        // 先清空上一次提交的图片
        oldImg = []
        imgList = []
        // 判断最后剩下的图片，如果是File类型的，放入 imgList 中
        // 如果不是，就是初始图片，放入 oldImg 中
        if (newImg.length > 0) {
            for (let i = 0; i < newImg.length; i++) {
                // 如果是，则放入 imgList 中
                if (newImg[i] instanceof File == true) {
                    imgList.push(newImg[i])
                } else {
                    oldImg.push(newImg[i])
                }
            }
        }
        formData = pickInfo(state, $(this), imgList)
        // 如果有 oldImg 则放入 oldImg
        if (oldImg.length > 0) {
            for (let i = 0; i < oldImg.length; i++) {
                formData.append('oldimage[]', oldImg[i])
            }
        }
        // 最后放入 id
        formData.append('id', id)
        upload_info(formData, '/lostfound/controller/data-edit.php', '')
        $('.shadow').click()
    })
    // 放入新的图片
    $('.datas').on('change', '.files', function () {
        for (let i = 0; i < $(this)[0].files.length; i++) {
            newImg.unshift($(this)[0].files[i])
        }
    })
    // 删除图片时将 newImg 中的图片也删除
    $('.datas').on('click', '.upload-box .delete', function () {
        let index = $(this).parent().parent().index()
        newImg.splice(index, 1)
    })

    // 获取修改数据并修改
    let id = 0
    let index = 0
    function edit(getUrl, target, oldImg, newImg) {
        $(target).on('click', '.edit-btn', function () {
            loading()
            id = gets($(this), target)
            $.ajax({
                url: `/lostfound/controller/${getUrl}`,
                type: 'post',
                dataType: 'json',
                data: { id: id },
                success: function (data) {
                    // console.log(data)
                    // 创建一个变量看看是不是待审核的数据
                    let row = data.row[0]
                    let head = data.head
                    let datas
                    // 获取 state
                    state = row['state']
                    // 清除上一次的记录
                    $('.datas').children().remove()
                    // 判断是 用户 还是 帖子 使用 hasOwnProperty() 判断
                    if (data.hasOwnProperty('image')) {
                        // 是帖子
                        datas = $(`
                            <div class="edit-report">
                                <div class="edit-box reports">
                                    <form method="post">
                                        <div class="item">
                                            <div class="troduce">
                                                <div class="mdui-textfield">
                                                    <label class="mdui-textfield-label edit-title">描述<span class="tips">*</span></label>
                                                    <textarea class="mdui-textfield-input message" name="troduce" required>${row['troduce']}</textarea>
                                                </div>
                                            </div>
                                            <div class="thre">
                                                <div class="address">
                                                    <div class="mdui-textfield">
                                                        <label class="mdui-textfield-label edit-title">丢失地点</label>
                                                        <input class="mdui-textfield-input message" name="address" type="text" value="${row['address']}" />
                                                    </div>
                                                </div>
                                                <div class="time">
                                                    <div class="mdui-textfield">
                                                        <label class="mdui-textfield-label edit-title">丢失时间</label>
                                                        <input class="mdui-textfield-input message" name="time" type="text" value="${row['time']}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info">
                                                <div class="mdui-textfield">
                                                    <label class="mdui-textfield-label edit-title">详细信息<span class="tips">*</span></label>
                                                    <textarea class="mdui-textfield-input message" name="info" required>${row['info']}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="image-upload">
                                            <label class="mdui-textfield-label edit-title">上传特征照片</label>
                                            <div class="upload-box">
                                                <div class="upload mdui-ripple mdui-color-indigo">
                                                    <i class="mdui-icon material-icons">add</i>
                                                    <div>上传图片</div>
                                                </div>
                                                <div class="add">
                                                    <div class="add-img" edit-title="上传图片">
                                                        <img src="../asset/upload-image.png">
                                                    </div>
                                                </div>
                                            </div>
                                            <input name="images[]" class="files" type="file" accept=".jpg,.jpeg,.png" multiple>
                                        </div>
                                        <div class="personal">
                                            <div class="name">
                                                <div class="mdui-textfield">
                                                    <label class="mdui-textfield-label edit-title">姓名</label>
                                                    <input class="mdui-textfield-input message" name="real_name" type="text" value="${row['real_name']}" />
                                                </div>
                                            </div>
                                            <div class="class">
                                                <div class="mdui-textfield">
                                                    <label class="mdui-textfield-label edit-title">所在班级</label>
                                                    <input class="mdui-textfield-input message" name="grades" type="text" value="${row['grades']}" />
                                                </div>
                                            </div>
                                            <div class="contact">
                                                <div class="mdui-textfield">
                                                    <label class="mdui-textfield-label edit-title">联系方式<span class="tips">*</span></label>
                                                    <input class="mdui-textfield-input message" name="contact" type="text" value="${row['contact']}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="edit-btns">
                                            <button class="mdui-btn mdui-btn-raised mdui-color-red-a700 edit-cancel">取消修改</button>
                                            <button class="mdui-btn mdui-btn-raised mdui-color-indigo edit-submit">修改数据</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        `)
                        // 获取图片
                        $.ajax({
                            url: '/lostfound/controller/edit-image.php',
                            type: 'POST',
                            dataType: 'json',
                            data: { id: id },
                            success: function (data) {
                                let img = data[0]
                                // 放入原本就有的图片
                                for (let i = img.length - 1; i >= 0; i--) {
                                    let imgDiv = $(
                                        `<div class="image">
                                            <div class="img" style="background: url('${img[i]}') center center / cover no-repeat;">
                                                <div class="delete"><i class="iconfont">&#xeca0;</i></div>
                                            </div>
                                        </div>`
                                    )
                                    $('.upload-box').prepend(imgDiv)
                                    // 初始图片
                                    newImg.unshift(img[i])
                                }
                                if ($('.upload-box .image').length !== 0) {
                                    imgNum = $('.upload-box .image').length
                                } else {
                                    imgNum = 0
                                }
                                imgNums(imgNum)
                            },
                        })
                    } else {
                        // 创建一个图片时间戳
                        let timeStamp = new Date().getTime()
                        // 放入用户数据
                        datas = $(
                            `<div class="edit-user">
                            <div class="edit-box">
                                <form method="post">
                                    <div class="user-top">
                                        <div class="user-heads">
                                            <div class="user-head" style="background: url('${head}?timestamp=${timeStamp}') center center / cover no-repeat;"></div>
                                            <div class="head-shade">
                                                <i class="mdui-icon material-icons modify-head">camera_alt</i>
                                            </div>
                                            <input type="file" class="select-user_head" name="avatar" accept=".jpg,.jpeg,.png" enctype="multipart/form-data">
                                        </div>
                                        <div class="user-info">
                                            <div>
                                                <div>用户名：</div>
                                                <input data-modify="false" type="text" class="modify-account" value="${row['account']}" maxlength="12">
                                            </div>
                                            <div>
                                                <div>密码：</div>
                                                <input data-modify="false" type="text" class="modify-password" value="${row['password']}" maxlength="16">
                                            </div>
                                            <div>
                                                <div>权限：</div>
                                                <select name="role" class="modify-role">
                                                    <option value="普通用户">普通用户</option>
                                                    <option value="管理员">管理员</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-bottom">
                                        <div>
                                            <div>昵称：</div>
                                            <input data-modify="false" type="text" class="modify-nickname" value="${row['nickname']}" maxlength="12">
                                        </div>
                                        <div>
                                            <div>真实姓名：</div>
                                            <input data-modify="false" type="text" class="modify-real_name" value="${row['real_name']}" maxlength="10">
                                        </div>
                                        <div>
                                            <div>班级：</div>
                                            <input data-modify="false" type="text" class="modify-class" value="${row['class']}" maxlength="16">
                                        </div>
                                        <div>
                                            <div>编号：</div>
                                            <input data-modify="false" type="text" class="modify-serial" value="${row['serial']}" maxlength="12">
                                        </div>
                                        <div>
                                            <div>联系方式：</div>
                                            <input data-modify="false" type="text" class="modify-contact" value="${row['contact']}" maxlength="11">
                                        </div>
                                        <div>
                                            <div>邮箱：</div>
                                            <input data-modify="false" type="text" class="modify-email" value="${row['email']}" maxlength="24">
                                        </div>
                                    </div>
                                    <div class="edit-btns">
                                        <div class="edit-cancel mdui-btn mdui-btn-raised">取消</div>
                                        <div class="edit-submit mdui-btn mdui-btn-raised mdui-color-indigo">确认修改</div>
                                    </div>
                                </form>
                            </div>
                        </div>`
                        )
                        let userDetail = ['account', 'nickname', 'password', 'real_name', 'class', 'serial', 'contact', 'email', 'role']
                        // 写入数据
                        for (let i = 0; i < userDetail.length; i++) {
                            userdata['modify-' + userDetail[i]] = row[userDetail[i]]
                        }
                    }
                    // 禁止滚动条进行滚动
                    disable_scroll()
                    // 写入
                    $('.datas').append(datas)
                    // 将 select 选项中提交默认值
                    if (target == '#user-list' || target == '#user-audit') {
                        if (row['role'] == 0) {
                            row['role'] = '普通用户'
                        } else {
                            row['role'] = '管理员'
                        }
                        let user_role = row['role']
                        for (let i = 0; i < $('.edit-box .modify-role option').length; i++) {
                            if ($('.edit-box .modify-role option').eq(i).val() == user_role) {
                                $('.edit-box .modify-role option').eq(i).prop('selected', 'selected')
                            }
                        }
                    }
                    unloading()
                    $('.shade').fadeIn(200)
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText)
                    unloading()
                    // 关闭 shade
                    $('.shadow').click()
                },
            })
        })
    }
    // 图片数量
    function imgNums(imgNum) {
        if (imgNum >= 1) {
            $('.upload-box').children('.upload').fadeOut(0)
            $('.add').fadeIn(0)
        } else {
            $('.upload-box').children('.upload').fadeIn(0)
            $('.add').fadeOut(0)
        }
    }
})
