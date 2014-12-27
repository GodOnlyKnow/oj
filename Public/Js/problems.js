window.onload = function () {
    var height = $('#contest-info').height();
    $('#pad').css({
        'height': height,
        'width': '1px',
        'margin': '0 auto'
    });

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
    $('#processbar').css('width', parseInt((now - start_time) / len * 100) + '%');
    setInterval("loop()", 1000);
    $("#1Btn,#2Btn,#3Btn").each(function () {
        $(this).click(function () {
            if ($(this).attr('class') != 'active') {
                $('.active').removeClass('active');
                $(this).addClass('active');
            }
        });
    });
    $("#CancelBtn").click(function () {
        $("#submitbar").modal('hide');
    });
    $(".submitbtn").click(function () {
        $('#returninfo').text('');
        $("#submitbar").modal();
    });
    $('.tostatus').click(function () {
        self.location.href = statusUrl;
    });
}
function submitpro(pid,cid){
    $('#returninfo').text('');
    var lg = $(".active").attr('id');
    lg = new Number(lg[0]);
    if(isNaN(lg))lg=2;
    if (myCodeMirror.getValue() == '')
    return;
$.post(submitproUrl, {
    "pid": pid,
    "cid": cid,
    "code": myCodeMirror.getValue(),
    "language": new Number(lg[0])
}, function (data) {
    if (data['status'] == 1) {
        $('#returninfo').text('You should Log in first');
    }
    else if (data['status'] == 2) {
        $('#returninfo').text('You can submit because this is a Team Contest and you have no team');
    }
    else if (data['status'] == 3) {
        $('#returninfo').text('Something wrong!!Please try again');
    }
    else if (data['status'] == 4) {
        self.location.href = statusUrl;
    }
}, 'json');
}
function loop()
{
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