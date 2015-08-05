/**
 * Created by Administrator on 2015/7/31.
 */
(function ($, Yiipal) {
    $(document).ready(function(){
        bindEventModal();
    });

    var bindEventModal = function(){
        $(".ajax-modal").click(function(){
            var options = {};
            options.url = $(this).attr("href");
            if($(this).attr("modal-title")){
                options.title = $(this).attr("modal-title");
            }
            Yiipal.modal.ajax(options);
            return false;
        });
    };

    Yiipal.behaviors.ajax = {
        attach: function (context, settings) {
            $(context).find("a.ajax").one('click',function(){
                alert(123);
                return false;
            });
        }
    };

})(jQuery, Yiipal);