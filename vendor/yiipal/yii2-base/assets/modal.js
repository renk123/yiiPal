(function ($, window, Yiipal) {
    Yiipal.modal = Yiipal.modal || {COUNT: 1000};
    Yiipal.modal.ajax = function(options){
        var uuid,$dialog;
        if(options.uuid){
            uuid = options.uuid;
            $dialog = $("#" + uuid);
            if ($dialog.length <= 0) {
                $dialog = $("<div />").attr("id", uuid).addClass("pop-up-box");
                $dialog.appendTo($("body"));
            }
        } else {
            uuid = "YiipalDialog_"+this.COUNT;
            this.COUNT++;
            $dialog = $("<div />").attr("id", uuid).addClass("pop-up-box");
            $dialog.appendTo($("body"));
        }

        Yiipal.modal.$dialog = $dialog;
        options.dataType = options.dataType || "html";
        options.ajaxType = options.ajaxType || "post";

        $.ajax({
            type: options.ajaxType,
            url: options.url,
            dataType: options.dataType,
            data: options.data || {},
            success: function (html) {
                var content = $('<div class="container"/>').html(html);
                $dialog.html(content);
                Yiipal.attachBehaviors($dialog);
                Yiipal.modal.showDialog(options);
            }
        });
    };

    Yiipal.modal.showDialog = function(options){
        $dialog = Yiipal.modal.$dialog;
        $dialog.dialog({
            title: options.title || "信息窗口",
            modal: true, // 设置为模态对话框
            resizable:options.resizable==1?false:true,
            width: options.width || 'auto',
            height: options.height || 'auto',
            full: options.full,
            position: options.position || "center", // 窗口显示的位置
            maximize: true,
            minimize: false,
            refresh: {
                type: options.ajaxType,
                url: options.url,
                data:options.data||{},
                dataType: options.dataType
            },
            MaximizeText: "最大化",
            MinimizeText: "最小化",
            RestoreText: "还原",
            RefreshText: "刷新",
            customWH: options.customWH,
            //buttons: {
            //    "保存": function(){},
            //    "取消": function() {
            //        $dialog.dialog( "close" );
            //    }
            //},
            close: function() {
                $(this).dialog("destroy");
                $dialog.remove();
                if (options.closeCallBack)
                    options.closeCallBack();
            }
        });

        if (!options.customWH) {
            $dialog.dialog("autoWH")	// 根据内容只适应宽高
                .dialog({position: "center"});	//	居中
        }
        if (options.dialogCallBack)
            options.dialogCallBack($dialog);
    };

    //用于Boostrap的modal，暂时不用
    Yiipal.modal.getDialogTpl = function(title,id){
        var tpl = '<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel" id="'+id+'">'
            +  '<div class="modal-dialog" role="document">'
            +    '<div class="modal-content">'
            +      '<div class="modal-header">'
            +        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
            +        '<h4 class="modal-title" id="gridSystemModalLabel">'+title+'</h4>'
            +      '</div>'
            +      '<div class="modal-body">'
            +        '<div class="container-fluid">'
            +          '<div class="row">'
            +          '</div>'
            +        '</div>'
            +      '</div>'
            +      '<div class="modal-footer">'
            +        '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'
            +        '<button type="button" class="btn btn-primary">保存</button>'
            +      '</div>'
            +    '</div>'
            +  '</div>'
            +'</div>';
        return tpl;
    };

})(jQuery, this, Yiipal);