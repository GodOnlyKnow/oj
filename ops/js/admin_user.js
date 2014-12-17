var OP = -1, ID = "";
var arr = ['#gid','#phone','#email','#name','#psd','#username'];

function selectAll(){
    $("input[type=checkbox]").each(function () {
         $(this).prop("checked",!this.checked);
    });
}

function btnClick(op,id,th){
    OP = op, ID = "" + id;
    if (op == 1){
        for (var i = 0; i < arr.length;i++ ) $(arr[i]).val("");
        $("#addModel").modal('show');
    } else if (op == 2){
        $("#delModel").modal('show');
    } else if (op == 3) {
        $(th).parent().prevAll().each(function (i) {
            $(arr[i]).val($(this).text());
        });
        $("#addModel").modal('show');
    } else {
        var str = "(";
        var flag = 0;
        $(".cbox").each(function (i) {
            if ($(this).prop('checked') == true) {
                if (flag == 0) { str = str + $(this).attr("data-uid"); flag = 1; }
                else str = str + "," + $(this).attr("data-uid");
            }
        });
        str = str + ")";
        ID = str;
        if (flag == 0) return;
        $("#delModel").modal('show');
    }
}

$(function () {
    $("#addModel form").submit(function () {
        var username = $("#username").val();
        var psd = $("#psd").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var name = $("#name").val();
        var gid = $("#gid").val();
        if (username.length < 1 || psd.length < 1) {
            $("#checkTips").html("用户名或密码不能为空。");
            return false;
        }
        if (email.length < 1) {
            $("#checkTips").html("邮箱不能为空。");
            return false;
        }
        if (gid == null) {
            $("#checkTips").html("请选择所在用户组");
            return false;
        }
        $.post("db.php", { op: OP, id: ID, n: name, u: username, ps: psd, e: email, p: phone, g: gid }, function (data) {
            $("#addModel").modal('hide');
            $("#tipTxt").html(data);
            $("#tipModel").modal('show');
        });
        return false;
    });

    $("#delModel form").submit(function () {
        $.post("db.php", { op: OP, id: ID }, function (data) {
            $("#delModel").modal('hide');
            $("#tipTxt").html(data);
            $("#tipModel").modal('show');
        });

        return false;
    });
});