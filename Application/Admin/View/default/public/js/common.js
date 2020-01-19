$(document).ready(function () {
    //全选
    $('#chkAll').click(function () {
        $("#form1 :checkbox").not('disabled').prop('checked', $("#chk").is(':checked'));
        setbg();
        if ($("#chk").is(':checked')) {
            $("#form1 :checkbox:checked").not('#chk').each(function (index, el) {
                $(this).closest('.list_tr').addClass('foribg');
                $(this).closest('.li').addClass('selected');
            });
        } else {
            $("#form1 :checkbox").not('#chk').each(function (index, el) {
                $(this).closest('.list_tr').removeClass('foribg');
                $(this).closest('.li').removeClass('selected');
            });
        }

    });
    // 反选
    $("#form1 :checkbox").not('#chk').click(function (event) {
        //console.log();
        if ($(this).is(':checked')) {
            $(this).closest('.list_tr').addClass('foribg');
            $(this).closest('.li').addClass('selected');
            if ($("#form1 :checkbox:checked").not('#chk').length == $("#form1 :checkbox").not('#chk').length) {
                $("#chk").prop('checked', !0);
            }
        } else {
            $(this).closest('.list_tr').removeClass('foribg');
            $(this).closest('.li').removeClass('selected');
            $("#chk").prop('checked', 0);
        }
    });

    //打开表单更多选项
    $('#J_moreform').click(function () {
        $(".moreform").toggle();
    });
    //监听表单单选（单项目。单选项）
    $('.imgchecked,.imgchecked_small').live('click', function () {
        var thisInput = $(this).find("input");
        var thisCode = $(this).data('code').split(',');
        if ($(this).hasClass('select')) {
            thisInput.val(thisCode[0]);
            $(this).removeClass('select');
        } else {
            thisInput.val(thisCode[1]);
            $(this).addClass('select');
        }
    })
    //监听表单单选(多项目。单选项)
    $('.imgradio .radio').live('click', function () {
        if ($(this).hasClass('disabled')) return false;
        $(this).parent().find("div").removeClass('select');
        $(this).addClass('select');
        data = $(this).attr('data');
        data1 = $(this).attr('data1');
        $(this).parent().find("input").eq(0).val(data);
        $(this).parent().find("input").eq(1).val(data1);
    });
    //列表页关键字高亮
    $strikingkey = $('.footso .sinput').val()
    if ($strikingkey && isNaN($strikingkey)) {
        $('.striking').highlight($strikingkey);
    }
    //文本框变色
    //$("input[type='text']").focus(function(){$(this).css({"border-color":"#0066CC #9DCEFF #9DCEFF #0066CC","background-color":"#EEF8FF"})});
    //$("input[type='text']").blur(function(){$(this).css({"border-color":"","background-color":""})});
    //单选和复选状态
    $("input[type='checkbox'],input[type='radio']").live('click', function () {
        setbg()
    });
    setbg();
//设置label背景
    function setbg() {
        $(":checkbox").parent("label").css("color", "#666666");
        $(":checkbox[checked]").parent("label").css("color", "#009900");
        $(":radio").parent("label").css("color", "#666666");
        $(":radio[checked]").parent("label").css("color", "#009900");
    }

//模拟select


    showmenu("#J_key_click", "#J_key_type_id", "#J_key_type_cn", "#J_mlist");

    seltpye_y(".seltpye_y");

});


function showmenu(J_click, type_id, type_cn, showID) {
    $(J_click).die().live('click', function () {
        $(J_click).blur();
        //$(menuID).parent("div").css("position","relative");
        $(showID).slideToggle("fast");
        //生成背景
        $(J_click).parent("div").before("<div class=\"menu_bg_layer\"></div>");
        $(".menu_bg_layer").height($(document).height());
        $(".menu_bg_layer").css({width: "100%", position: "fixed", left: "0", top: "0", "z-index": "0"});
        //生成背景结束
        $(showID + " li").live('click', function () {
            $(J_click).text($(this).attr("title"));
            $(type_id).val($(this).attr("id"));
            $(type_cn).val($(this).attr("title"));
            $(".menu_bg_layer").remove();
            $(showID).hide();
            //$(menuID).parent("div").css("position","");
            $(this).css("background-color", "");
        });

        $(".menu_bg_layer").live('click', function () {
            $(".menu_bg_layer").remove();
            $(showID).hide();
            //$(menuID).parent("div").css("position","");
        });
    });
}
function seltpye_y(seltpye_y) {
    $(seltpye_y).live('click', function () {
        var sel = $(this);
        sel.blur();
        sel.find('.downlist').slideToggle("fast");
        sel.before("<div class=\"menu_bg_layer\"></div>");
        $(".menu_bg_layer").height($(document).height());
        $(".menu_bg_layer").css({width: "100%", position: "fixed", left: "0", top: "0", "z-index": "0"});
        sel.find('li').live('click', function () {
            //$(".menu_bg_layer").remove();
            //sel.find('.downlist').hide();
            var url = $(this).attr('url');
            window.location = url;
        });
        $(".menu_bg_layer").live('click', function () {
            $(".menu_bg_layer").remove();
            sel.find('.downlist').hide();
            //$(menuID).parent("div").css("position","");
        });

    });
}
 