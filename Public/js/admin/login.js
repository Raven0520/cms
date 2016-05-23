/**
 * Created by Raven on 2016/5/9.
 */
/*
 *前端登陆业务类
 */

var login = {
    check: function () {
        //获取登陆页面中的用户名和密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();


        if (!username) {
            dialog.error('用户名不能为空');
        }
        if (!password) {
            dialog.error('密码不能为空');
        }

        var url = "index.php?m=admin&c=login&a=check";
        var data = {'username': username, 'password': password};
        //执行异步请求  $.post
        $.post(url, data, function (result) {
            if (result.status === 0) {
                return dialog.error(result.message);
            }

            if (result.status == 1) {
                return dialog.success(result.message, 'index.php?m=admin&c=index');
            }
        }, 'JSON');
    }
};