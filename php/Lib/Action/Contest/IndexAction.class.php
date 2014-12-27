<?php
    class IndexAction extends Action{
        public function index()
        {
            header("content-type:text/html;charset=utf-8");
            $nowpage=I('p',1);
            $info=I('info',NULL);
            //dump(M('contest')->getdberror());
            $Model= new Model();

            if($info==NULL)
            $sql='select count(*) from contest order by contest.level desc;';
            else   $sql='select count(*) from contest where contest.name like "%'.$info.'%" order by contest.level desc;';
            $arr = $Model->query($sql);
            $this->nowpage=$nowpage;
            $totalnum=20;
            $pages=floor($arr[0]['count(*)']/$totalnum);
            $pages+=$arr[0]['count(*)']%$totalnum==0?0:1;
            $this->pages=$pages;
            $this->info=$info;
            $now=($nowpage-1)*$totalnum;
            if($info==NULL)
            $sql='select * from contest order by contest.level desc limit '.$now.','.$totalnum.';';
            else $sql='select * from contest where contest.name like "%'.$info.'%" order by contest.level desc limit '.$now.','.$totalnum.';';
            $arr = $Model->query($sql);
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
                $time1=$time1-$time2;
                
                $sec = $time1%60;$time1=($time1-$sec)/60;
                $min = $time1%60;$time1=($time1-$min)/60;
                $hou = $time1;
                if($sec<10)$sec='0'.$sec;
                if($hou<10)$hou='0'.$hou;
                if($min<10)$min='0'.$min;
                $arr[$row]['length']=$hou.':'.$min.':'.$sec;
            }
            $this->data=$arr;
            $this->display(index);
        }
        public function form()
        {
            $conid=I('contestid');
            $conpas=I('contestpas',"");
            $conditon['cid']=$conid;
            $sql = M('contest');
            $res=$sql->where($conditon)->select();
            //通过返回数字表示验证结果
            //0通过验证
            //1需要密码
            //2密码错误
            //3不被邀请
            //4需要登陆
            if($res[0]['password']!='')
            {
                $flag =0;
                if($_SESSION['item'])
                {
                    $item = $_SESSION['item'];
                    $arr = explode('|',$item);
                    //p($arr);
                    foreach($arr as $i)
                    {
                        if($i==$res[0]['cid'])
                        $flag=1;
                    }
                }
                //之前验证过
                if($flag==1)
                {
                    $this->ajaxReturn(array('status'=>0),'json');
                }
                //提示输入密码
                else if($conpas=="")
                {
                    $this->ajaxReturn(array('status'=>1),'json');
                }
                //验证输入密码
                else
                {
                    if($res[0]['password']==$conpas)
                    {
                        //private的比赛判定
                        if($_SESSION['item']==NULL)
                        $_SESSION['item']="";
                        $_SESSION['item']=$_SESSION['item'].'|'.$res[0]['cid'];

                        $this->ajaxReturn(array('status'=>0),'json');
                    }
                    else{
                        $this->ajaxReturn(array('status'=>2),'json');
                    }
                }
            }
            else if($res[0]['private']==1){
                if($_SESSION['uid'])
                {
                    $uid = $_SESSION['uid'];
                    $res = M('contest_user');
                    $con = array(
                        'uid'=>$uid,
                        'cid'=>$conid
                    );
                    $result = $res->where($con)->select();
                    if($result&&$result[0]['ischeck']==1)
                    {
                        if($_SESSION['item']==NULL)
                        $_SESSION['item']="";
                        $_SESSION['item']=$_SESSION['item'].'|'.$conid;
                        $this->ajaxReturn(array('status'=>0),'json');     
                    }
                    else
                    {
                        $this->ajaxReturn(array('status'=>3),'json');
                    }
                }
                else
                {
                    $this->ajaxReturn(array('status'=>4),'json');
                }
            }
            else
            {  
                //什么都不要验证 直接跳转
                $this->ajaxReturn(array('status'=>0),'json');
            }
        }
        public function problemlist()    
        {
            header("content-type:text/html;charset=utf-8");
            $id= I('cid','0');
            if($id==0)$this->redirect('index');
            $flag = 0;
            $start_time=0;

            $conditon['cid']=$id;
            $Model=new Model();
            $sql='select * from contest where cid='.$id;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $this->contestinfo=$arr;
            $start_time=$res[0]['start_time'];
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            $this->isrunning=1;
            if($nowtime<strtotime($start_time)){
                $this->isrunning=2;
                $this->empty='Contest start at '.$start_time;
            }
            else
            {
                $Model = new Model();
                $sql='select p.pid,pc.newid,pc.newname,pc.accpet,pc.submit from problem as p,contest_problem as pc where p.pid=pc.pid and pc.cid='.$id.' order by newid';
                $res = $Model->query($sql);
                
                $this->data=$res;
                $this->cid = $id;
            }
            $this->display();
        }
        public function problem()
        {
            $conid=I('cid',0);
            $proid=I('pid','0');
            //die();
            if($conid==0||$proid=='0')
            {
                $this->redirect('index');
            }
            $Model=new Model();
            $sql='select * from contest where cid='.$conid;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $flag = 0;
            $this->contestinfo=$arr;
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            
            if($nowtime<strtotime($res[0]['start_time'])){
                $this->redirect('problemlist?cid='.$conid);
            }
            $sql='select pc.cid,pc.newid from contest_problem as pc where pc.cid='.$conid.' order by newid';
            $res = $Model->query($sql);
            $this->problems=$res;

            $sql='select * from problem as p,contest_problem as pc where p.pid=pc.pid and pc.cid='.$conid.' and pc.newid="'.$proid.'" order by newid';
            $res = $Model->query($sql);
            $this->problem=$res;

            //dump($Model->getdberror());
            $this->display();
        }
        public function submitpro(){
            if($_POST){
                $cid=I('cid',0);
                $pid=I('pid',0);
                $code=I('code','');
                $language=I('language','');
                $uid;
                if($cid==0||$pid==0)
                $this->redirect('index');
                if(isset($_SESSION['uid'])){
                    $uid=$_SESSION['uid'];
                }
                else{
                    $this->ajaxReturn(array('status'=>1),'json');
                }
                header("Content-Type:text/html; charset=utf-8");
                $Dao = M("solution");	// 实例化模型类

                // 数据对象赋值
                $Dao->cid = $cid;
                $Dao->pid = $pid;
                $Dao->uid = $uid;
                $Dao->code=$code;
                $Dao->language=$language;

                $Model=new Model();
                $sql='select type from contest where cid ='.$cid;
                $res=$Model->query($sql);
                if($res[0]['type']==1)
                {
                    $sql='select tid from user where uid ='.$uid;
                    $arr=$Model->query($sql);
                    if($arr[0]['tid']==NULL)
                    $this->ajaxReturn(array('status'=>2),'json');
                }    
                // 写入数据
                if($lastInsId = $Dao->add()){
                    $this->ajaxReturn(array('status'=>4),'json');
                } else {
                    $this->ajaxReturn(array('status'=>3),'json');
                }
            }
        }
        public function register()
        {
            header("content-type:text/html;charset=utf-8");
            if($_POST){
                $newcid=I('contestid',0);
                //echo $newcid."<br />";
                if($newcid==0)$this->redirect('index');
                if(isset($_SESSION['uid'])){
                    $this->ajaxReturn(array('status'=>1,id=>$newcid),'json');
                }
                else{
                    $this->ajaxReturn(array('status'=>0,id=>$newcid),'json');
                }
            }
            else{
                $username=NULL;
                $userid=NULL;
                $contestid=I('cid',0);
                if($contestid==0){
                    $this->redirect('index');
                }
                if(isset($_SESSION['uid'])){
                    $userid=$_SESSION['uid'];
                    $username=$_SESSION['name'];
                }
                $query = I('query',0);
                $arr=array();
                $Model = new Model('contest_user');
                $sql='select name from contest where cid='.$contestid;
                $res = $Model->query($sql);
                $this->contestname=$arr['contestname']=$res[0]['name'];
                if($query==1&&$username!=NULL)
                {
                    $arr['username']=$username;
                    $sql='select * from contest_user where cid='.$contestid.' and uid='.$userid;
                    $res = $Model->query($sql);
                    if($res==NULL)
                    {
                        $data["uid"] = $userid;
                        $data['cid'] =$contestid;
                        if($lastInsId = $Model->add($data)){
                            $arr['flag']=1;$arr['result']=NULL;//注册成功
                        } else {
                            echo $Model->getdberror();
                            $arr['flag']=3;//注册失败
                        }
                    }
                    else {
                        $arr['flag']=2;//已经注册
                        $arr['result']=$res[0]['ischeck'];
                    }
                    
                    $this->data=$arr;
                }
                $sql='select username,ischeck from user,(select *from contest_user where contest_user.cid='.$contestid.') p where user.uid=p.uid;';
                $res = $Model->query($sql);
                $this->otherdata=$res;
                
                $this->display();
            }
            
        }
        public function status()
        {
            $conid=I('cid',0);
            if($conid=='0')
            {
                $this->redirect('index');
            }
            $Model=new Model();
            $sql='select * from contest where cid='.$conid;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                $this->isend=0;
                if($nowtime>$time1){$arr[$row]['sta']='Ended';$this->isend=1;}
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $flag = 0;
            $this->contestinfo=$arr;
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            if($nowtime<strtotime($res[0]['start_time'])){
                $this->redirect('problemlist?cid='.$conid);
            }
            $sql='select count(*) from solution where cid='.$conid;
            $arr = $Model->query($sql);
            $nowpage=I('p',1);
            $totalnum=20;
            $pages=floor($arr[0]['count(*)']/$totalnum);
            $pages+=$arr[0]['count(*)']%$totalnum==0?0:1;
            $this->pages=$pages;
            $this->nowpage=$nowpage;
            $this->info=$info;
            $now=($nowpage-1)*$totalnum;
            
            $sql='select * from solution where cid='.$conid.' order by create_time desc limit '.$now.','.$totalnum.';';
            $res=$Model->query($sql);
            //dump($res);
            $this->solution=$res;

            if($_SESSION['uid'])$this->youruid=$_SESSION['uid'];
            else $this->yourid='';

            //dump($Model->getdberror());
            $this->display();
        }
        public function report()
        {
            $conid=I('cid',0);
            if($conid=='0')
            {
                $this->redirect('index');
            }
            $Model=new Model();
            $sql='select * from contest where cid='.$conid;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $flag = 0;
            $this->contestinfo=$arr;
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            if($nowtime<strtotime($res[0]['start_time'])){
                $this->redirect('problemlist?cid='.$conid);
            }
            $sql = 'select * from news where cid='.$conid;
            $res=$Model->query($sql);
            if($res)$this->news=$res;
            $this->display();
        }
        public function replay(){
            $type=I('type',0);
            $id=I('id',0);
            $context=I('context','');
            $uid;
            if($_SESSION['uid'])$uid=$_SESSION['uid'];
            else {
                $this->ajaxReturn(array('status'=>0),'json');
            }
            if($type==1)
            {
                header("Content-Type:text/html; charset=utf-8");
                $Dao = M("contest_replay");	// 实例化模型类

                // 数据对象赋值
                $Dao->cfid = $id;
                $Dao->context = $context;
                $Dao->uid = $uid;

                // 写入数据
                if($lastInsId = $Dao->add()){
                    $this->ajaxReturn(array('status'=>1),'json');
                } else {
                    $this->ajaxReturn(array('status'=>2),'json');
                }
            }
            else if($type==2)
            {
                $til=I('title','');
                header("Content-Type:text/html; charset=utf-8");
                $Dao = M("contest_forum");	// 实例化模型类

                // 数据对象赋值
                $Dao->cid = $id;
                $Dao->title = $til;
                $Dao->context = $context;
                $Dao->author = $_SESSION['name'];
                $Dao->uid = $id;
                // 写入数据
                if($lastInsId = $Dao->add()){
                    $this->ajaxReturn(array('status'=>1),'json');
                } else {
                    $this->ajaxReturn(array('status'=>2),'json');
                }
            }
        }
        public function clarify()
        {
            $conid=I('cid',0);
            if($conid=='0')
            {
                $this->redirect('index');
            }
            $Model=new Model();
            $sql='select * from contest where cid='.$conid;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $flag = 0;
            $this->contestinfo=$arr;
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            if($nowtime<strtotime($res[0]['start_time'])){
                $this->redirect('problemlist?cid='.$conid);
            }
            
            $sql='select * from contest_forum where cid='.$conid;
            $arr=$Model->query($sql);
            foreach($arr as $row=>$each)
            {
                $sql='select c.cfid,c.uid,u.username,c.context,c.create_time from contest_replay as c,user as u where c.cfid='.$arr[$row]['cfid'].
                ' and c.uid=u.uid order by c.create_time;';
                $res=$Model->query($sql);
                $arr[$row]['replay']=$res;
                
            }
            $this->replay=$arr;
            $this->display();
        }
        public function prin(){
            $conid=I('cid',0);
            if($conid=='0')
            {
                $this->redirect('index');
            }
            $Model=new Model();
            $sql='select * from contest where cid='.$conid;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $flag = 0;
            $this->contestinfo=$arr;
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            if($nowtime<strtotime($res[0]['start_time'])){
                $this->redirect('problemlist?cid='.$conid);
            }
            $this->display();
        }
        public function rank(){
            $conid=I('cid',0);
            if($conid=='0')
            {
                $this->redirect('index');
            }
            $Model=new Model();
            $sql='select * from contest where cid='.$conid;
            $res=$Model->query($sql);
            $arr=$res;
            foreach($arr as $row=>$each)
            {
                $time1 = strtotime($arr[$row]['end_time']);
                $time2= strtotime($arr[$row]['start_time']);
                $arr[$row]['len']=$time1-$time2;
                $arr[$row]['startinunix']=$time2;
                $nowtime=time();
                if($nowtime>$time1)$arr[$row]['sta']='Ended';
                else if($nowtime<$time2)$arr[$row]['sta']='Pending';
                else $arr[$row]['sta']='Running';
            }
            $flag = 0;
            $this->contestinfo=$arr;
            if($res[0]['password']==NULL&&$res[0]['private']==0)$flag=1;
            //else $this->redirect('index');
            if($_SESSION['item']&&$flag==0)
            {
               $item = $_SESSION['item'];
               $arr = explode('|',$item);
               foreach($arr as $i)
               {
                   if($i==$id)
                   $flag=1;
               }
            }
            if($flag==0)
            $this->redirect('index');
            $nowtime = time();
            if($nowtime<strtotime($res[0]['start_time'])){
                $this->redirect('problemlist?cid='.$conid);
            }
            $this->display();
        }
        public function rankdata(){
            $conid=I('cid',0);
            $Model = new Model();
            $sql='select uid as pa_id,pid,result,create_time from solution where cid='.$conid.' order by pa_id,pid,create_time;';
            $arr=$Model->query($sql);

            $sql='select create_time,type,private from contest where cid='.$conid;
            $start_time = $Model->query($sql);
            $type=$start_time[0]['type'];
            $private=$start_time[0]['private'];
            $start_time=$start_time[0]['create_time'];
            $sql='select pid from contest_problem where cid='.$conid.' order by newid;';
            $pro=$Model->query($sql);
            //echo 'idaaaaa='.$conid;
            if($type==0)//个人赛
            {
                if($private==0)//公开赛
                {
                    $sql='select distinct user.uid as pa_id,user.username as pa_name from solution,user where solution.uid=user.uid and cid='.$conid.' order by pa_id';
                    $users = $Model->query($sql);
                }
                //需要报名
                else{
                    $sql='select distinct user.uid as pa_id,user.username as pa_name from contest_user,user where contest_user.uid=user.uid and contest_user.ischeck!=0 and cid=6 order by pa_id';
                    $users = $Model->query($sql);
                }
            }
            else//组队赛
            {
                if($private==0)//公开赛
                {
                    $sql='select distinct tid from contest_team where cid=6';
                    $users = $Model->query($sql);
                }//需要报名
                else{
                    
                }
            }
            //dump($arr);
            //dump($pro);
            //echo $start_time;
            //dump($users);
            //die();
            $res = dealRankData($arr,$start_time,$pro,$users);
            //p($res);
            $this->ajaxReturn($res,'json');
        }
        public function newscount(){
            $conid=I('cid',0);
            $Model = new Model();
            $sql='select * from news where cid='.$conid;
            $res= $Model->query($sql);
            $count=count($res);
            $this->ajaxReturn(array('status'=>$count),'json');
        }
        
    }

?>
