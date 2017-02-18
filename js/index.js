function message(type, title, txt) {
		setTimeout(function() {
			toastr.options = {
				closeButton: true,
				progressBar: true,
				showMethod: 'fadeIn',
				hideMethod: 'fadeOut',
				timeOut: 10000,
			};
			if (type == 'success') toastr.success(txt, title);
			if (type == 'info') toastr.info(txt, title);
			if (type == 'warning') toastr.warning(txt, title);
			if (type == 'error') toastr.error(txt, title);
		},1000);
	}

jQuery(document).ready(function($) {
    if($("meta[name=toTop]").attr("content")=="true"){
        $("<div id='toTop'><img src='/Public/images/totop.png'></div>").appendTo('body');
        $("#toTop").css({
            width: '50px',
            height: '50px',
            bottom:'10px',
            right:'15px',
            position:'fixed',
            cursor:'pointer',
            zIndex:'999999'
        });
        if($(this).scrollTop()==0){
            $("#toTop").hide();
        }
        $(window).scroll(function(event) {
            /* Act on the event */
            if($(this).scrollTop()==0){
                $("#toTop").hide();
            }
            if($(this).scrollTop()!=0){
                $("#toTop").show();
            }
        });
        $("#toTop").click(function(event) {
            /* Act on the event */
            $("html,body").animate({
                    scrollTop:"0px"},
                666
            )
        });
    }


    //瀑布流插件

    //结束

    //插件发布的ajax
    $("#SendServer").click(function(){
		$('#editor').val(CKEDITOR.instances.editor.getData())
		console.log($("#ServerData").serialize());
        var CheckIfEmpty = 0;
        $("#ServerData").find("input").each(function(){
            if ($(this).val() == "") {
                $(this).addClass("uk-form-danger");
                CheckIfEmpty++;
            }
        });

        if(CheckIfEmpty == 0){
            var AjaxData;
            AjaxData = $("#ServerData").serialize();
            $.ajax({
                url: "/Developer/AddPlugin",
                async:true,
                type: 'POST',
                dataType:'json',
                data:AjaxData,
                error:function(e){
                    message('error','错误',"未知原因失败");
					$("#SendServer").removeAttr("disabled");
					console.log(e);
                },
                beforeSend:function(){
                    $("#SendServer").attr({"disabled":"disabled"});
					$("#SendServer").text("正在发布……");
                },
                success:function(data){
                    if(data == true){
						message('success','消息','插件添加成功！');
                        window.location = '/Developer/';
                        return true;
                    }else if(data == false){
						message('warning','Waring','请先登录！');
						$("#SendServer").removeAttr("disabled");
						$("#SendServer").text("发布！");
                        return true;
                    }else{
						message('error','错误5003','添加失败！');
						$("#SendServer").removeAttr("disabled");
						$("#SendServer").text("发布！");
                    }
                    var overdata = "";
                    $.each(data,function(k,value) {
						message('error',k,value);
                    });
                }
            });
        }else{
			message('warning','Waring','请完整填写信息！');
            return true;
        }
    });
    $("#ServerData").find("input").blur(function(){
        if($(this).val() !== ""){
            $(this).removeClass("uk-form-danger");
        }
    });


    //不为空时的颜色改变
    $("input").blur(function(){
        if($(this).val() !== ""){
            $(this).removeClass("form-red");
        }
    });
});
//测试的函数
function WriteObj(obj){
    var description = "";
    for(var i in obj){
        var property=obj[i];
        description+=i+" = "+property+"\n";
    }
    alert(description);
}

function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end))
        }
    }
    return ""
}

function setCookie(c_name,value,expiredays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

/**删除购物车的东西
 * @return {boolean}
 */
function DelCartOnce(SCID){
    SCID = Number(SCID);
    $.get('/User/AddCart',{'do':'del','scid':SCID},function(data){
        if(data == true){
            UIkit.notify("删除成功！",{ status:'success',timeout:1000});
        }else{
            UIkit.notify("删除失败！",{ status:'danger',timeout:1000});
        }
    });
    return true;
}

