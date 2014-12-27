var OP = -1, ID = "";
var arr = ['#name'];

function selectAll(){
    $(".cbox").each(function () {
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

function users(id){
    $.post('getUsers.php', { tid: id }, function (data) {
        $("#users").html(data);
    });
}

function removeUser(id){
    $.post('user.php', { uid: id }, function (data) {
        $('#tipTxt').html(data);
        $("#tipModel").modal('show');
    });
}

function addUser(id){
    var d = $('#uids').val();
    if (d.length < 1){
        $('#addTips').html("输入用户编号");
        return;
    }
    var ds = d.split(',');
    for (var i = 0;i < ds.length;i++){
        if (isNaN(parseInt(ds[i]))){
            $('#addTips').html("输入不合法");
            return;
        }
    }
    $.post('add.php', { tid: id, uid: d }, function (data) {
        $('#tipTxt').html(data);
        $("#tipModel").modal('show');
        users(id);
    });
}

$(function () {
    $("#datatable").dataTable({
        "bProcessing": true
    });

    $("#addModel form").submit(function () {
        var name = $("#name").val();
        if (name.length < 1) {
            $("#checkTips").html("名称不能为空！");
            return false;
        }
        $.post("db.php", { op: OP, id: ID, n: name}, function (data) {
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