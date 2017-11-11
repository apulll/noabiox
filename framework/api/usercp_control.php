<?php
/***********************************************************
	Filename: {phpok}/api/usercp_control.php
	Note	: 会员中心数据存储
	Version : 4.0
	Web		: www.phpok.com
	Author  : qinggan <qinggan@188.com>
	Update  : 2013年11月5日
***********************************************************/
if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");}
class usercp_control extends phpok_control
{
	private $u_id; //会员ID
	private $u_name; //会员名字
	private $is_client = false;//判断是否客户端
	public function __construct()
	{
		parent::control();
		$token = $this->get('token');
		if($token){
			$info = $this->lib('token')->decode($token);
			if(!$info || !$info['user_id'] || !$info['user_name']){
				$this->json(P_Lang('您还没有登录，请先登录或注册'));
			}
			$this->u_id = $info['user_id'];
			$this->u_name = $info['user_name'];
			$this->is_client = true;
		}else{
			if(!$_SESSION['user_id']){
				$this->json(P_Lang('您还没有登录，请先登录或注册'));
			}
			$this->u_id = $_SESSION['user_id'];
			$this->u_name = $_SESSION['user_name'];
		}
	}

	/**
	 * 存储个人数据
	 * @参数 
	 * @参数 
	 * @参数 
	 * @参数 
	 * @返回 
	 * @更新时间 
	**/
	public function info_f()
	{
		$email = $this->get('email');
		$mobile = $this->get('mobile');
		if($email){
			if(!$this->lib('common')->email_check($email)){
				$this->json('邮箱格式不正确');
			}
			$chk = $this->model('user')->uid_from_email($email,$this->u_id);
			if($chk){
				$this->json(P_Lang('邮箱已被使用，请更换其他邮箱'));
			}
		}
		if($mobile){
			if(!$this->lib('common')->tel_check($mobile,'mobile')){
				$this->json('手机号格式不正确');
			}
			$uid = $this->model('user')->uid_from_mobile($mobile,$this->u_id);
			if($uid){
				$this->json(P_Lang('手机号码已被使用'));
			}
		}
		$array = array('email'=>$email,'mobile'=>$mobile);
		$this->model('user')->save($array,$this->u_id);
		$this->json(true);
	}

	//更新会员头像
	public function avatar_f()
	{
		$data = $this->get('data');
		if(!$data){
			$this->json(P_Lang('头像图片地址不能为空'));
		}
		$pInfo = pathinfo($data);
		$fileType = strtolower($pInfo['extension']);
		if(!$fileType || !in_array($fileType,array('jpg','gif','png','jpeg'))){
			$this->json(P_Lang('头像图片仅支持jpg,gif,png,jpeg'));
		}
		if(!file_exists($this->dir_root.$data)){
			$this->json(P_Lang('头像文件不存在'));
		}
		$this->model('user')->update_avatar($data,$this->u_id);
		$this->json(true);
	}

	//更新会员密码功能
	public function passwd_f()
	{
		$oldpass = $this->get("oldpass");
		if(!$oldpass){
			$this->json(P_Lang('旧密码不能为空'));
		}
		$newpass = $this->get("newpass");
		$chkpass = $this->get("chkpass");
		if(!$newpass || !$chkpass){
			$this->json(P_Lang('新密码不能为空'));
		}
		if(strlen($newpass) < 6){
			$this->json(P_Lang('密码不符合要求，密码长度不能小于6位'));
		}
		if(strlen($newpass) > 20){
			$this->json(P_Lang('密码不符合要求，密码长度不能超过20位'));
		}
		if($newpass != $chkpass){
			$this->json(P_Lang('新旧密码不一致'));
		}
		$user = $this->model('user')->get_one($this->u_id);
		if(!password_check($oldpass,$user["pass"])){
			$this->json(P_Lang('旧密码输入错误'));
		}
		if($oldpass == $newpass){
			$this->json(P_Lang('新旧密码不能一样'));
		}
		$password = password_create($newpass);
		$this->model('user')->update_password($password,$this->u_id);
		if(!$this->is_client){
			$this->model('user')->update_session($this->u_id);
		}
		$this->json(true);
	}
}