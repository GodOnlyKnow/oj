var isd = 0, isa = 0, ism = 0,isCheck = 1,ID = -1,AID = -1,OPA = 1;
    function setVar(d, a, m) {
        isd = d;
        isa = a;
        ism = m;
    }

    function level(op,lid){
        ID = lid;
        if (op == 0) {
            var ns = "#lid" + lid;
            $("#inputName").val($(ns).text());
            $("#inputDesci").val($(ns).attr("data-desci"));
            isCheck = 3;
            $("#addModel").modal('show');
        } else if (op == 1){
            $("#delModel").modal('show');
        } else {
            isCheck = 1;
            $("#inputName").val("");
            $("#inputDesci").val("");
            $("#addModel").modal('show');
        }
    }

    function alevel(op,alid){
        if (op == 1){
            OPA = 1;
            $("#inputAName").val("");
            $("#inputADesci").val("");
            $("#addAModel").modal('show');
        } else if (op == 2){
            AID = alid;
            $("#delAModel").modal('show');
        } else {
            AID = alid;
            var ns = "#alid" + alid;
            $("#inputAName").val($(ns).attr('data-name'));
            $("#inputADesci").val($(ns).attr('data-desci'));
            OPA = 3;
            $("#addAModel").modal('show');
        }
    }

    function getAlevel(id) {
        AID = id;
        $.post("getAlevel.php", { lid: id, d: isd, a: isa, m: ism }, function (data) {
            var str = "";
            if (isa) str = "<tr><td colspan='3'><a class='btn btn-default' onclick='alevel(1,-1)' >添加</a></td></tr>"
            str += "<tr><th>名称</th><th>指向页面</th><th>操作</th></tr>" + data;
            $("#secMenu").html(str);
        });
    }

    $(function () {

        $("#delModel form").submit(function () {
            $.post('level.php', { op: 2, lid: ID }, function (data) {
                $("#delModel").modal('hide');
                $("#tipTxt").html(data);
                $("#tipModel").modal('show');
            });
            return false;
        });

        $("#delAModel form").submit(function () {
            $.post('alevel.php', { op: 2, alid: AID }, function (data) {
                $("#delAModel").modal('hide');
                $("#tipTxt").html(data);
                $("#tipModel").modal('show');
            });
            return false;
        });

        $("#addAModel form").submit(function () { 
            var inputName = $("#inputAName").val();
            var inputDesci = $("#inputADesci").val();
            if (inputName.length == 0) {
                $("#checkATips").html("权限名称不能为空.");
                return false;
            }
            if (inputDesci.length == 0) {
                $("#checkATips").html("详细描述不能为空.");
                return false;
            }
            $.post('alevel.php', { op: OPA, alid: AID, name: inputName, desci: inputDesci }, function (data) {
                $("#addAModel").modal('hide');
                $("#tipTxt").html(data);
                $("#tipModel").modal('show');
            });
            return false;
        });

        $("#addModel form").submit(function () {
            var inputName = $("#inputName").val();
            var inputDesci = $("#inputDesci").val();
            if (inputName.length == 0) {
                $("#checkTips").html("权限名称不能为空.");
                return false;
            }
            if (inputDesci.length == 0) {
                $("#checkTips").html("所属目录不能为空.");
                return false;
            }
            $.post('level.php', { op: isCheck, lid: ID, name: inputName, desci: inputDesci }, function (data) {
                $("#addModel").modal('hide');
                $("#tipTxt").html(data);
                $("#tipModel").modal('show');
            });
            return false;
        });
    });