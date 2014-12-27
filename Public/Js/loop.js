window.onload = function () {
    altRows('alternatecolor');
    var d = new Date()
    var now = parseInt(d.getTime() / 1000);
    var vYear = d.getFullYear()
    var vMon = d.getMonth() + 1
    var vDay = d.getDate()
    var h = d.getHours();
    var m = d.getMinutes();
    var se = d.getSeconds();
    var s = vYear + "-" + (vMon < 10 ? "0" + vMon : vMon) + "-" + (vDay < 10 ? "0" + vDay : vDay) + " " + (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m) + ":" + (se < 10 ? "0" + se : se);
    $("#currenttime")[0].innerHTML = s;
    console.log('now=' + now + '   start=' + start_time + '  len=' + len);
    $('#processbar').css('width', parseInt((now - start_time) / len*100) + '%');
    setInterval("loop()", 1000);
}
var count = 0;
function loop()
{
    var d = new Date();
    var now = parseInt(d.getTime() / 1000);
    var vYear = d.getFullYear()
    var vMon = d.getMonth() + 1
    var vDay = d.getDate()
    var h = d.getHours();
    var m = d.getMinutes();
    var se = d.getSeconds();
    var s = vYear + "-" + (vMon < 10 ? "0" + vMon : vMon) + "-" + (vDay < 10 ? "0" + vDay : vDay) + " " + (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m) + ":" + (se < 10 ? "0" + se : se);
    $("#currenttime")[0].innerHTML = s;
    $('#processbar').css('width', parseInt((now - start_time) / len*100)+'%');
    $.post(countUrl,
    {
        cid: cid
    },
    function (data) {
        if (data['status'] != 0) {
            $('.badge').text(data['status']);
        }
    },
    'json');

}
function altRows(id) {
    if (document.getElementsByTagName) {
        var table = document.getElementById(id);
        if (table == null) return;
        var rows = table.getElementsByTagName("tr");

        for (i = 0; i < rows.length; i++) {
            if (i % 2 != 0) {
                rows[i].className = "evenrowcolor";
                rows[i].getElementsByTagName('td')[0].className = "evencolcolor";
                
            } else {
                rows[i].className = "oddrowcolor";
                var cols = rows[i].getElementsByTagName("td");
                if (cols[0] != null)
                    cols[0].className = "oddcolcolor";
            }
        }
    }
}
function replay(cfid,num){
    if($('#text'+num).val()=='')
    {
        return;
    }
    $.post(replayUrl,
    {
        context: $('#text' + num).val(),
        type: 1,
        id: cfid
    },
    function (data) {
        //没登陆
        if (data['status'] == 0) {
            ;
        }
        //插入数据出错
        else if (data['status'] == 2) {
            ;
        }
        //成功
        else {
            location.reload();
        }
    },
    'json');
}
function publish(cid){
    if($('#til').val()==''||$('#con').val()=='')
    {
        return;
    }
    $.post(replayUrl,
    {
        title:$('#til').val(),
        context: $('#con').val(),
        type: 2,
        id: cid
    },
    function (data) {
        //没登陆
        if (data['status'] == 0) {
            ;
        }
        //插入数据出错
        else if (data['status'] == 2) {
            ;
        }
        //成功
        else {
            location.reload();
        }
    },
    'json');
}