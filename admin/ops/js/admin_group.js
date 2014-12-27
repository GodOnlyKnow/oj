var OP = 1,ID = -1;
var arr = ['#desci','#name'];

function btnClick(op,id,th){
    OP = op, ID = id;
    if (op == 1){
        for (var i = 0; i < arr.length;i++ ) $(arr[i]).val("");
        $("#addModel").modal('show');
    } else if (op == 2){
        $("#delModel").modal('show');
    } else {
        $(th).parent().prevAll().each(function (i) {
            $(arr[i]).val($(this).text());
        });
        $("#addModel").modal('show');
    }
}

function saveChange(gid){
    var str = "";
    $("#predom input[type=checkbox]").each(function () {
        var that = this;
        if ($(this).prop("checked")) {
            if ($(that).data("id") != undefined) {
                if (str == "") str = $(that).data("id");
                else str += "," + $(that).data("id");
            }
        }
    });
    $.post("save.php",{g:gid,p:str},function(data){
        $("#tipTxt").html(data);
        $("#tipModel").modal('show');
    });
}

function getLevel(gid){
    $.post("getLevel.php", { g: gid }, function (data) {
        $("#predom").html(data);
    });
}

$(function () {
    $("#addModel form").submit(function () {
        var name = $("#name").val();
        var desci = $("#desci").val();
        if (name.length < 1 || desci.length < 1) {
            $("#checkTips").html("名称或描述不能为空。");
            return false;
        }
        $.post("db.php", { op: OP, id: ID, n: name, d: desci }, function (data) {
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