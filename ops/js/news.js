var OP, ID;
function selectAll(){
    $(".cbox").each(function () {
         $(this).prop("checked",!this.checked);
    });
}

function btnClick(op,id){
    OP = op, ID = "" + id;
    if (op == 1){
        
    } else if (op == 2){
        $("#delModel").modal('show');
    } else if (op == 3) {
        
    } else {
        var str = "(";
        var flag = 0;
        $(".cbox").each(function (i) {
            if ($(this).prop('checked') == true) {
                if (flag == 0) { str = str + $(this).attr("data-pid"); flag = 1; }
                else str = str + "," + $(this).attr("data-pid");
            }
        });
        str = str + ")";
        if (flag == 0) return;
        ID = str;
        $("#delModel").modal('show');
    }
}

function IndexNews(){
    $("#datatable").DataTable().column(2).search('').draw();
}

$(function () {
    $("#datatable").dataTable({
        "bProcessing": true
    });

    $("#txtSearch").bind('keyup click', function () {
        $("#datatable").DataTable().column(2).search(
            $("#txtSearch").val()
        ).draw();
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