window.onload = function () {
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
    $('#processbar').css('width', parseInt((now - start_time) / len * 100) + '%');
    setInterval("loop()", 1000);
}
var count = 0;
function loop() {
    update();
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
    $('#processbar').css('width', parseInt((now - start_time) / len * 100) + '%');
    if (count % 3 == 0)
        $.post(rankdataUrl,
    {
        cid: conid
    },
    function (data) {
        callback(data);
    },
    'json');
    count++;
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
var last = null; //当前排行榜的数组
var queue = Array(); //动画数据队列
var pre = 0, las = 0; //队列指针
var flag = 0; //动画是否完成标记
var pTop = 0; //动画元素的坐标
var pLeft = 0; //动画元素坐标
var isstart = 0;//没有人提交比赛 需要生成表格的头部、只生成一次
var cla = function () {
    this.oldid = null;
    this.newid = null;
    this.info = new Array();
};
function callback(data){
    if (data[0].goal_nth == -1 && isstart == 0) {
        isstart = 1;
        var leng = data[0].slv_problems;
        var pagewidth = $('#info').width();
        var each = pagewidth / (leng + 5);
        if (each < 60) each = 60;
        var tablestr = "";
        tablestr = '<table class="altrowstable">';
        tablestr += '<tr><th style="width:' + each + 'px" class="rank">Rank</th>';
        tablestr += '<th style="width:' + each*2 + 'px" >Name</th>';
        tablestr += '<th style="width:' + each + 'px" >Slove</th>';
        tablestr += '<th style="width:' + each + 'px" >Time</th>';

        for (var i = 0; i < leng; i++)
            tablestr += '<th style="width:' + each + 'px">' + String.fromCharCode(65 + i) + '</th>';
        tablestr += '</tr>';
        tablestr += '</table>';
        $('#info').append(tablestr);
        return;
    }
    else if (data[0].goal_nth == -1 && isstart == 1) return;
    if (last == null) {last = data; showpage(data);}
    if (data.length != last.length)location.reload();
    for (var i = 0; i < data.length; i++) {
       if (last[i].pa_id != data[i].pa_id) {
           for (var j = 0; j < data.length;j++)
           {
               if (last[j].pa_id == data[i].pa_id) {
                   console.log('now its different! st=' + last[j].id + ' end=' + data[i].id);
                   var cal = new cla();
                   cal.oldid = last[j].id;
                   cal.newid = data[i].id;
                   cal.info = data[i];
                   queue[las++] = cal;
                   break;
               }
           }
       }
       else
       {
           modifyrow(data[i],data[i].id);
       }
    }
    last = data;
}
function update() {
    console.log('pre=' + pre + "  end=" + las);
    if (flag == 0 && pre < las) {
        var obj = queue[pre];
        var oldid = obj.oldid;
        var newid = obj.newid;
        var info = obj.info;
        console.log('this one ' + info + "from =" + oldid + "  end =" + newid);
        pre++;
        move(oldid, newid, info);
    }
    if (pre == las) pre = las = 0;
}
function move(fromid, toid, info){
            flag = 1;
            var ex = document.getElementById(toid);
            var left = document.getElementById(toid).offsetLeft  ;
            var top = document.getElementById(fromid).offsetTop +document.getElementById('info').offsetTop ;
            var ttop = document.getElementById(toid).offsetTop + document.getElementById('info').offsetTop;
            var leng=info.is_first.length;
            var str='<table class="altrowstable" id="newtable" style="position: absolute;top:'+top+'px;left:'+left+'px">';
            console.log('start! fromtop='+top+" totop="+ttop+" left="+left);
            var pagewidth=$('#info').width();
            var each = pagewidth/(leng+5);
            str+=geteachrow(fromid,info,leng,each);
            str+='</table>';
            $('#info').append(str);
            var newtable='#newtable';
            var div = $(newtable);
            div.animate({ top: ttop, left: left, opacity: '1' }, 800, function () {
                modifyrow(info,toid);
                $(newtable).remove();
                flag = 0;
            });
}
function showpage(data){
    var leng = data[0].is_first.length;
    var pagewidth=$('#info').width();
    var each = pagewidth/(leng+5);
    if(each<60)each=60;
    var tablestr="";
    tablestr='<table class="altrowstable" id="ran">';
    tablestr+='<tr><th style="width:'+each+'px" class="rank">Rank</th>';
    tablestr+='<th style="width:'+each+'px" >Name</th>';
    tablestr+='<th style="width:'+each+'px" >Slove</th>';
    tablestr+='<th style="width:'+each+'px" >Time</th>';
    
    for(var i=0;i<leng;i++)
    tablestr+='<th style="width:'+each+'px">'+String.fromCharCode(65+i)+'</th>';
    tablestr+='</tr>';
    for(var i=1;i<=data.length;i++)
    {
        var obj = data[i-1];
        tablestr+=geteachrow(i,obj,leng,each);
    }
    tablestr+='</table>';
    $('#info').append(tablestr);
}
function gettime(time)
{
    var s = time%60;time=parseInt(time/60);
    var m = time%60;time=parseInt(time/60);
    var h =time;
    if(s<10)s='0'+s;
    if(m<10)m='0'+m;
    if(h<10)h='0'+h;
    return h+':'+m+':'+s;
}
function geteachrow(i,obj,leng,each){
    var tablestr='';
    if(obj.goal_nth==1)
        tablestr+='<tr id="'+i+'" class="goal">';
        else if(obj.goal_nth==2)
        tablestr+='<tr id="'+i+'" class="silver">';
        else if(obj.goal_nth==3)
        tablestr+='<tr id="'+i+'" class="bronze">';
        else
        tablestr+='<tr id="'+i+'" class="normal">';
        tablestr+='<td style="width:'+each+'px" id="'+i+'rank">'+obj.id+'</td>';
        tablestr+='<td style="width:'+each*2+'px" id="'+i+'name">'+obj.pa_name+'</td>';
        tablestr+='<td style="width:'+each+'px" id="'+i+'solve">'+obj.slv_problems+'</td>';
        tablestr+='<td style="width:'+each+'px" id="'+i+'time">'+gettime(obj.tot_time)+'</td>';
        for(var j=0;j<leng;j++)
        {

            tablestr+='<td style="width:'+each+'px" id="'+i+String.fromCharCode(65+j)+'"';
            var content="----";
            if(obj.is_first[j]==1)
            {
                tablestr+=' class="firstblood">';
                content=gettime(obj.pass_time[j]);
                if(obj.try_problems[j]>=1)
                content+='(-'+obj.try_problems[j]+')';
            }
            else if(obj.pass_time[j]!=0)
            {
                tablestr+=' class="accept">';
                content=gettime(obj.pass_time[j]);
                if(obj.try_problems[j]>=1)
                content+='(-'+obj.try_problems[j]+')';
            }
            else if(obj.try_problems[j]==0)
            {
                tablestr+='class="normal">';
            }
            else
            {
                tablestr+=' class="wrong">';
                content='(-'+obj.try_problems[j]+')';
            }
            tablestr+=content+'</td>'
        }
        tablestr+='</tr>';
        return tablestr;
}
function modifyrow(obj,toid)
{
    $('#' + toid).removeClass();
    if (obj.goal_nth == 1)
      $('#' + toid).addClass('goal');
    else if (obj.goal_nth == 2)
    $('#' + toid).addClass('silver');
    else if (obj.goal_nth == 3)
      $('#' + toid).addClass('bronze');
    else
      $('#' + toid).addClass('normal');
    $('#' + toid + 'rank').html(obj.rank);
    $('#' + toid + 'name').html(obj.pa_name);
    $('#' + toid + 'solve').html(obj.slv_problems);
    $('#' + toid + 'time').html(obj.tot_time);
    for (var j = 0; j < leng; j++) {
        var tid = '#' + toid + String.fromCharCode(65 + j);
        $(tid).removeClass();
        var content = "----";
        if (obj.is_first[j] == 1) {
            $(tid).addClass('firstblood');
            content = gettime(obj.pass_time[j]);
            if (obj.try_problems[j] >= 1)
                content += '(-' + obj.try_problems[j] + ')';
        }
        else if (obj.pass_time[j] != 0) {
            $(tid).addClass('accept');
            content = gettime(obj.pass_time[j]);
            if (obj.try_problems[j] >= 1)
                content += '(-' + obj.try_problems[j] + ')';
        }
        else if (obj.try_problems[j] == 0) {
            $(tid).addClass('normal');
        }
        else {
            $(tid).add('wrong');
            content = '(-' + obj.try_problems[j] + ')';
        }
        $(tid).html(content);
    }
}