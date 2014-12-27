var CID = -1;
function addUser(cid){
    CID = cid;
    $.Dialog({
        title: '添加参赛人员',
        overlay: true,
        shadow: true,
        flat: true,
        content: '',
        padding: 10,
        onShow: function (_dialog) {
            var content = "<div><input type='text' id='uid' name='uid' placeholder='输入编号，多个用\",\"分割' /></div>" +
                            "<button class='info' onclick='addUserClick()'>Submit</button>";
            $.Dialog.content(content);
        }
    });
}

function addUserClick(){
    var uid = $('#uid').val();
    if (uid.length < 1) return;
     var ds = uid.split(',');
    for (var i = 0;i < ds.length;i++){
        if (isNaN(parseInt(ds[i]))){
            alert("输入不合法");
            return;
        }
    }
    $.post('addUser.php', { c: CID, u: uid }, function (data) {
        $.Dialog.close();
        $.Dialog({
            title: '',
            overlay: true,
            shadow: true,
            flat: true,
            content: data,
            padding: 10
        });
    });
}

function delUser(id,cid){
    $.post('delUser.php', {c:cid, i: id }, function (data) {
        $.Dialog.close();
        $.Dialog({
            title: '',
            overlay: true,
            shadow: true,
            flat: true,
            content: data,
            padding: 10
        });
    });
}

function delNews(id, cid) { 
    $.post('delNews.php', {c:cid, i: id }, function (data) {
        $.Dialog.close();
        $.Dialog({
            title: '',
            overlay: true,
            shadow: true,
            flat: true,
            content: data,
            padding: 10
        });
    });
}

function checkUser(id,cid){
    $.post('checkUser.php', { c: cid, i: id }, function (data) {
        location.reload();
    });
}

function addProblem(cid){
    CID = cid;
    $.Dialog({
        title: '添加题目',
        overlay: true,
        shadow: true,
        flat: true,
        content: '',
        padding: 10,
        onShow: function (_dialog) {
            var content = "<div><input type='text' id='pid' name='pid' placeholder='输入编号，多个用\",\"分割' /></div>" +
                            "<button class='info' onclick='addProblemClick()'>Submit</button>";
            $.Dialog.content(content);
        }
    });
}

function addProblemClick(){
    var pid = $('#pid').val();
    if (pid.length < 1) return;
     var ds = pid.split(',');
    for (var i = 0;i < ds.length;i++){
        if (isNaN(parseInt(ds[i]))){
            alert("输入不合法");
            return;
        }
    }
    $.post('addProblem.php', { c: CID, p: pid }, function (data) {
        $.Dialog.close();
        $.Dialog({
            title: '',
            overlay: true,
            shadow: true,
            flat: true,
            content: data,
            padding: 10
        });
    });
}

function delProblem(id,cid){
    $.post('delProblem.php', {c:cid, i: id }, function (data) {
        $.Dialog.close();
        $.Dialog({
            title: '',
            overlay: true,
            shadow: true,
            flat: true,
            content: data,
            padding: 10
        });
    });
}

$(function () {
    $("#tab_3_2 form").submit(function () {
        var title = $("#title").val();
        var txt = $("#context").val();
        var cid = $("#fcid").val();
        if (title.length < 1 || txt.length < 1) return;
        $.post("addNews.php", { t: title, r: txt, c: cid }, function () {
            location.reload();
        });

        return false;
    });
});