var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();
var id=new Number($_GET['problemid']);
$(function(){
	var top=document.getElementById("back1").offsetHeight-20;
	var backwidth=$("#topba").width();
	var backmarginleft=backwidth/2;
	$("#back1").css({
		"width":backwidth+"px",
		"margin-left":-backmarginleft+"px"
	});
	$("#pno").css({
		"width":backwidth+"px",
		"margin-left":-backmarginleft+"px"
	});
	
	$("#submitbar").on('hidden.bs.modal', function () {
		myCodeMirror.setValue("");
	});
	$("#bottombtn").css("margin-top",top);
	$(".Pre").click(function(){
		window.location.href='Problem'+'?problemid='+(id-1);
	});
	$(".Next").click(function(){
		window.location.href='Problem'+'?problemid='+(id+1);
	});
	$("#0Btn,#1Btn,#2Btn").each(function(){
		$(this).click(function(){
			if($(this).attr('class')!='active'){
				$('.active').removeClass('active');
				$(this).addClass('active');
			}
		});
	});
	$("#CancelBtn").click(function(){
		$("#submitbar").modal('hide');	
	});
	$("#SubmitBtn").click(function(){
		var lg=$(".active").attr('id');
		$.post(SubmitUrl,{
			"pid":id,
			"code":myCodeMirror.getValue(),
			"language":new Number(lg[0])
		},function(data){
		},'json');
		window.location.href="Status";
	});
})
function loginTrue(){
	$("#submitbar").modal();
}
function loginFalse(){
	$("#loginbar").modal();
	$(".loginba").parent().find($('.alert')).remove();
	$(".loginba").after("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a>Please login first</div>");
}