/**
 * ajax提交form
 */
function ajaxSubmit(form, successCallback = null, errorCallback = null) {
    form.on('submit', function(data) {
        var $btn = $(data.elem); // 提交按钮
        var oldTxt = $btn.text();
        var loadingTips = $btn.data('loading');
        if (loadingTips) {
            $btn.text(loadingTips);
        } else {
            $btn.text(oldTxt + '中...');
        }
        $btn.addClass('layui-btn-disabled');

        $.ajax({
            type: 'post',
            url: $(data.form).attr('action'),
            data: data.field,
            dataType: 'json'
        }).done(function(res) {
            if (res.status == 1) {
                if (successCallback) {
                    successCallback(res);
                } else {
                    alert(res.msg);
                    if (res.url) {
                        location.href = res.url;
                    } else {
                        location.reload();
                    }
                }
            } else {
                if (errorCallback) {
                    errorCallback(res);
                } else {
                    alert(res.msg);
                }
            }
        }).fail(function() {
            alert('服务器错误或网络异常');
        }).always(function() {
            $btn.text(oldTxt).removeClass('layui-btn-disabled');
        });
        
        return false;
    });
}