<?php
class IndexAction extends Action {
    public function Index(){
    	$this->display();
	}
	public function Login(){
		
    	$username=i('username','','');
    	$password=i('password','','md5');
    	$user=m('user')->where(array('username' => $username))->find();
		if(!$user)
			$this->ajaxreturn(1,'json');
		else if($user["password"]!=$password)
			$this->ajaxreturn(1,'json');
		else{
			session('uid',$user['uid']);
			session('username',$user['username']);
			cookie('username',$user['username']);
			$this->ajaxreturn(0,'json');
		}
	}
	public function Register(){
		
		$data['username']=I('username','','');
		$data['password']=I('password','','md5');
		$data['email']=I('email','','');
		$user=M('user');
		$user->add($data);
		session('username',$data['username']);
		$this->ajaxReturn(0,'json');
	}
	public function checkValue(){
		$username=I('username','','');
		$flag=I('flag','','');
		if($flag==0){
		$user=m('user')->where(array('username' => $username))->find();
		if($user){
			$this->ajaxreturn(0,'json');
		}
		else{
			$this->ajaxreturn(1,'json');
		}
		}
		else if($flag==1){
			if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->ajaxreturn(0,'json');
		}
		else{
			$this->ajaxreturn(1,'json');
		}
		}
		else{
			session('username',NULL);
			$this->ajaxreturn(0,'json');
		}
	}
	public function verify(){
		import('ORG.Util.Image');
        ob_end_clean();
		Image::buildImageVerify(6,5,'png',80,34);
	    
    }
	public function ProblemList(){
		$page=I('page',1); //获取要显示的页面值
		$info=I('info',NULL);
		$num=10; //每页显示数目
		$model=new Model();
		if($info==NULL){
			$sql="select * from problem;";
		}
		else{
			$sql='select * from problem where problem.pname like "%'.$info.'%" or problem.source like "%'.$info.'%";';
		}
		$total=count($model->query($sql));
		$pages=ceil($total/$num);
		$this->pages=$pages;
		$this->nowpage=$page;
		$this->info=$info;
		$offset=($page-1)*$num;
		if($info==NULL){
			$sql="select * from problem limit $offset,$num;";
		}
		else{
			$sql="select * from problem where problem.pname like '%".$info."%' or problem.source like '%".$info."%' limit $offset,$num;";
		}
		$data=$model->query($sql);
		$this->data=$data;
		$this->display();
	}
	public function Problem(){
		$problemid=intval($_GET['problemid']);
		$data=M('problem')->where(array('pid' => $problemid))->find();
		
		if($data==NULL){
			echo "error : can not found the problem .";
		}
		else{
		$this->data=$data;
		$this->display();
		}
	}
	public function Submit(){
		$solu=M('solution');
		$data['uid']=$_SESSION['uid'];
		$data['pid']=I('pid','','');
		$data['language']=I('language','','');
		$data['result']=0;
		$data['code']=I('code','','');
		$solu->add($data);
		$this->ajaxReturn();
	}
	public function Status(){
		$page=I('page',1); //获取要显示的页面值
		$info=I('info',NULL);
		$num=10; //每页显示数目
		$model=new Model();
		if($info==NULL){
			$sql="select s.soid,s.pid,s.result,s.create_time,s.memory,s.time,s.language,u.username from solution s,user u where s.uid=u.uid  order by soid desc;";
		}
		else{
			$sql="";
		}
		$total=count($model->query($sql));
		$pages=ceil($total/$num);
		$this->pages=$pages;
		$this->nowpage=$page;
		$this->info=$info;
		$offset=($page-1)*$num;
		if($info==NULL){
			$sql="select s.soid,s.pid,s.result,s.create_time,s.memory,s.time,s.language,u.username from solution s,user u where s.uid=u.uid  order by soid desc limit $offset,$num;";
		}
		else{
			$sql="";
		}
		$data=$model->query($sql);
		$this->data=$data;
		$this->display();
	}
	public function Statistic(){
		
	}
	public function RecentNews(){
		$page=I('page',1); //获取要显示的页面值
		$info=I('info',NULL);
		$num=10; //每页显示数目
		$model=new Model();
		if($info==NULL){
			$sql="select u.username,n.title,n.context,n.create_time from news n,admin_user u where n.uid=u.uid and ISNULL(n.cid)  order by n.create_time desc;";
		}
		else{
			$sql="select u.username,n.title,n.context,n.create_time from news n,admin_user u where n.uid=u.uid and ISNULL(n.cid) and n.title like '%".$info."%'  order by n.create_time desc;";
		}
		$total=count($model->query($sql));
		$pages=ceil($total/$num);
		$this->pages=$pages;
		$this->nowpage=$page;
		$this->info=$info;
		$offset=($page-1)*$num;
		if($info==NULL){
			$sql="select u.username,n.title,n.context,n.create_time from news n,admin_user u where n.uid=u.uid and ISNULL(n.cid)  order by n.create_time desc limit $offset,$num;";
		}
		else{
			$sql="select u.username,n.title,n.context,n.create_time from news n,admin_user u where n.uid=u.uid and ISNULL(n.cid) and n.title like '%".$info."%'  order by n.create_time desc limit $offset,$num;";
		}
		$data=$model->query($sql);
		$this->data=$data;
		$this->display();
	}
}