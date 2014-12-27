<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>HouDun许愿墙</title>
     <script type="text/ecmascript">
        var handleUrl = '<?php echo U("Index/Index/handle", '', '');?>';
    </script>
	<script type="text/javascript" src='__PUBLIC__/Js/jquery-1.10.2.min.js'></script>
    <style>
        td{
            padding: 10px;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var last = null; //当前排行榜的数组
        var queue = Array(); //动画数据队列
        var pre = 0, las = 0; //队列指针
        var flag = 0; //动画是否完成标记
        var pTop = 0; //动画元素的坐标
        var pLeft = 0; //动画元素坐标
        last = [
            { 'id': 1, 'name': 'yang' },
            { 'id': 2, 'name': 'wang' },
            { 'id': 3, 'name': 'zhou' },
            { 'id': 4, 'name': 'zhao' }
            ];
        //自定义动画数据类型
        var cla = function () {
            this.oldid = null;
            this.newid = null;
            this.name = null;
            this.info = new Array();
        };
        //异步回调函数
        function getjson(data) {
            if (last == null) last = data;
            var interval;
            for (var i = 0; i < last.length; i++) {
                if (last[i].id != data[i].id) {
                    alert("!!___lasti=" + last[i].id + " datai=" + data[i].id);
                    var cal = new cla();
                    cal.oldid = last[i].id;
                    cal.newid = data[i].id;
                    cal.info = data[i];
                    queue[las++] = cal;
                    //alert(cal);
                }
            }
        }
        //动画改变前的数据更变
        function update() {
            console.log(flag);
            if (flag == 0 && pre < las) {
                console.log("2");
                var obj = queue[pre];
                var oldid = obj.oldid;
                var newid = obj.newid;
                var info = obj.info;
                pre++;
                var nowrow = document.getElementById(newid);
                //alert(nowrow);
                var Nodes = nowrow.childNodes;
                var cnt = 0;
                console.log(newid);
                move(oldid, newid, info);
            }
            if (pre == las) pre = las = 0;
        }
        //
        $(function () {
            $.post(handleUrl, function (data) {
                getjson(data);
            }, 'json');
            console.log("las=" + las);
            var interval = setInterval(update, 500);
        });
        //动画
        function move(fromid, toid, info) {
            flag = 1;
            var nowrow = document.getElementById(toid);
            //alert(nowrow);
            var Nodes = nowrow.childNodes;
            var newrow = document.createElement("tr");
            var flag = 0;
            for (i = 0; i < Nodes.length; i++) {
                if (Nodes[i].tagName == "TD") {
                    var newelemnt = document.createElement("td");
                    newelemnt.innerHTML = Nodes[i].innerHTML;
                    newrow.appendChild(newelemnt);
                }
            }
            var newtable = document.createElement("table");
            newtable.appendChild(newrow);
            document.body.appendChild(newtable);
            $(newtable).css("position", "absolute");
            //alert(mes);
            var ex = document.getElementById(toid);
            if (pTop == 0)
                while (ex = ex.offsetParent) {
                    pTop += ex.offsetTop;
                    pLeft += ex.offsetLeft;
                }
            var left = document.getElementById(toid).offsetLeft + pLeft;
            var top = document.getElementById(toid).offsetTop + pTop;
            var ttop = document.getElementById(fromid).offsetTop + pTop;
            $(newtable).css("top", top);
            $(newtable).css("left", left);
            $(newtable).css("opacity", "1");

            //alert(newtable.offsetLeft);
            //alert(newtable.offsetTop);

            $(newrow).css("background", "yellow");
            alert("生成")
            alert(toid + " : " + top + "    " + fromid + " : " + ttop);
            //$(nowrow).css("background", "blue");
            //alert(newrow);


            var targetleft = document.getElementById(fromid).offsetLeft + pLeft;
            var targettop = document.getElementById(fromid).offsetTop + pTop;

            var div = $(newtable);
            div.animate({ top: targettop, left: targetleft, opacity: '0.5' }, 800, function () {
                console.log("!+++++++++");
                console.log(info);

                $(newrow).remove();
                flag = 0;
            });

        }
    </script>
</head>
<body>
	<div id='top'>
		<span id='send'></span>
	</div>
        <p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p><p id="pp">111</p>
    <p id="test">111</p>
	<div id='main'>
        <table>
        <?php $i=1; ?>
        <?php if(is_array($wish)): foreach($wish as $key=>$v): ?><tr id="<?php echo $i++; ?>">
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["name"]); ?></td>
            </tr>
			<!--
            <dd class='content'><?php echo ($v["content"]); ?></dd>
			<dd class='bottom'>
				<span class='time'><?php echo (date('y-m-d h:i',$v["time"])); ?></span>
				<a href="" class='close'></a>
			</dd>
            --><?php endforeach; endif; ?>
        </table>
	</div>

	<div id='send-form'>
		<p class='title'><span>许下你的愿望</span><a href="" id='close'></a></p>
		<form action="<?php echo U('handle');?>" method="post" name='wish'>
			<p>
				<label for="username">昵称：</label>
				<input type="text" name='username' id='username'/>
			</p>
			<p>
				<label for="content">愿望：(您还可以输入&nbsp;<span id='font-num'>50</span>&nbsp;个字)</label>
				<textarea name="content" id='content'></textarea>
				<div id='phiz'>
					<img src="__PUBLIC__/Images/phiz/zhuakuang.gif" alt="抓狂" />
					<img src="__PUBLIC__/Images/phiz/baobao.gif" alt="抱抱" />
					<img src="__PUBLIC__/Images/phiz/haixiu.gif" alt="害羞" />
					<img src="__PUBLIC__/Images/phiz/ku.gif" alt="酷" />
					<img src="__PUBLIC__/Images/phiz/xixi.gif" alt="嘻嘻" />
					<img src="__PUBLIC__/Images/phiz/taikaixin.gif" alt="太开心" />
					<img src="__PUBLIC__/Images/phiz/touxiao.gif" alt="偷笑" />
					<img src="__PUBLIC__/Images/phiz/qian.gif" alt="钱" />
					<img src="__PUBLIC__/Images/phiz/huaxin.gif" alt="花心" />
					<img src="__PUBLIC__/Images/phiz/jiyan.gif" alt="挤眼" />
				</div>
			</p>
			<span id="send-btn"></span>
		</form>
	</div>
<!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/Js/iepng.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('#send,#close,.close','background');
    </script>
<![endif]-->
    <p id="pp">111</p>

</body>
</html>