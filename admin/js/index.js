function A(id) { return document.getElementById(id) }
var ising = false,isP = false;

function user_input() {
    var name = A("id").value;
    var password = A("password").value;

    var str = "";
    if (name.length < 4) {
        str += "用户名长度必须大于6个字符。";
    }
            if (password.length < 4) {
                str += "\n密码长度必须大于8个字符。"
            }
            if (str.length > 5) {
                alert(str);
            } else {
            $.post('lasttime.php', { uname: name, psd: password }, function (data) {
                $('.ILast').html(data);
                $('.last').css('display', 'block');
                $(".last").animate({ opacity: 1 }, 500, function () {
                    $(".last").animate({ opacity: 1 }, 2000, function () {
                        $(".last").animate({ opacity: 0 }, 500, function () {
                            $('.last').css('display', 'none');
                            if (data.charAt(0) == 'L' || data.charAt(0) == 'F')
                                location.href = "admin.php";
                        });
                    });
                });
            });
				
			}
			return false;
}
