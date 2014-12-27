window.onload = function () {
    altRows('alternatecolor');
    $('#passwordbtn').click(function () {
        var pas = $('#passwordvalue').val();
        sendform(pas);
    });
    $('#submitinfo').click(function () {
        var str = $('#searchinfo').val();
        if (str == '') return;
        window.location.href = indexUrl + "?info=" + str;
    });
}
function register(id)
{
    $.post(registerUrl,
    {
        contestid: id
    },
    function (data) {
        console.log(data['id']);
        if (data['status'] == 0) {
            $('#passwordbar').css('display', 'none');
            $('#passwordsend').css('display', 'none');
            $('#modalmessage').text('You should login first');
            $('#myModal').modal({
                keyboard: false
            });
        }
        else {
            self.location.href = registerUrl + "?cid=" + data['id']+"&query=1";
        }

    },
    'json');
}
function fun1() {
    $('#myModal').modal({
        keyboard: false
    });
}
function altRows(id) {
    if (document.getElementsByTagName) {

        var table = document.getElementById(id);
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
function getunix(string) {
    var f = string.split(' ', 2);
    var d = (f[0] ? f[0] : '').split('-', 3);
    var t = (f[1] ? f[1] : '').split(':', 3);
    return (new Date(
                parseInt(d[0], 10) || null,
                (parseInt(d[1], 10) || 1) - 1,
                parseInt(d[2], 10) || null,
                parseInt(t[0], 10) || null,
                parseInt(t[1], 10) || null,
                parseInt(t[2], 10) || null
                )).getTime() / 1000;
}
var ID;
function fun(id) {
    ID = id;
    $.post(formUrl,
    {
        contestid: id
    },
    function (data) {
        callback(data);
    },
    'json');
}
function sendform(pas) {
    $.post(formUrl,
    {
        contestid: ID,
        contestpas: pas
    },
    function (data) {
        callback(data);
    },
    'json');
}
var flag = 0;
function callback(data) {
    console.log("IIIIIIIIIIIIIIII BACK");
    if (data['status'] == 0) {
        self.location.href = handleUrl + "?cid=" + ID;
    }
    else if (data['status'] == 1) {
        $('#modalmessage').text('This contest need password');
        $('#passwordbar').css('display', 'block');
        $('#passwordsend').css('display', 'block');
        $('#myModal').modal({
            keyboard: false
        });
    }
    else if (data['status'] == 2) {
        $('#modalmessage').css('color', '#fdf000');
        $('#modalmessage').text('The password is not correct');
        if (flag == 0) {
            flag=1
            $('#modalmessage').animate({ color: 'black' }, 3000, function () { flag = 0; });
        }
    }
    else if (data['status'] == 3) {
        $('#passwordbar').css('display', 'none');
        $('#passwordsend').css('display', 'none');
        $('#modalmessage').text('You are not invited to this contest');
        $('#myModal').modal({
            keyboard: false
        });
    }
    else {
        $('#passwordbar').css('display', 'none');
        $('#passwordsend').css('display', 'none');
        $('#modalmessage').text('This contest is not Public You should login first');
        $('#myModal').modal({
            keyboard: false
        });
    }
}
function showmessage() {
    $('#modalmessage').text('This contest need password');
    $('#passwordbar').append('<input type="text" class="form-control" placeholder="Password">')
    $('#myModal').modal({
        keyboard: false
    });
}