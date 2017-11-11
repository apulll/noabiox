<?php
/**
 * 会员注册
 * @package phpok\www
 * @作者 qinggan <admin@phpok.com>
 * @版权 2015-2016 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 4.x
 * @授权 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2016年07月25日
**/

if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");}
class register_control extends phpok_control
{
	/**
	 * 构造函数
	**/
	public function __construct()
	{
		parent::control();
	}

	/**
	 * 注册页面，包含注册验证页，使用到模板：register_check_项目ID
	 * @参数 _back 返回上一页
	 * @参数 _code 验证码
	 * @参数 email 邮箱
	**/
	public function index_f()
	{
		$_back = $this->get("_back");
		if(!$_back){
			$_back = $this->config['url'];
		}
		if($this->session->val('user_id')){
			$this->error(P_Lang('您已登录，不用注册'),$_back);
		}
		$this->assign('_back',$_back);
		$this->view("register");
	}

	/**
	 * 保存注册信息
	 * @参数 _chkcode 验证码
	 * @参数 user 账号
	 * @参数 newpass 密码
	 * @参数 chkpass 确认密码
	 * @参数 email 邮箱
	 * @参数 mobile 手机号
	 * @参数 group_id 用户组ID
	 * @参数 _code 注册推广码
	 * @更新时间 2016年08月01日
	**/
	public function save_f()
	{
		if($this->session->val('user_id')){
			$this->error(P_Lang('您已是本站会员，不能执行这个操作'),$this->url);
		}
		$errurl = $this->url('register');
		if($this->config['is_vcode'] && function_exists('imagecreate')){
			$code = $this->get('_chkcode');
			if(!$code){
				$this->error(P_Lang('验证码不能为空'),$errurl);
			}
			$code = md5(strtolower($code));
			if($code != $this->session->val('vcode')){
				$this->error(P_Lang('验证码填写不正确'),$errurl);
			}
			$this->session->unassign('vcode');
		}
		//检测会员账号
		$user = $this->get("user");
		if(!$user){
			$this->error(P_Lang('账号不能为空'),$errurl);
		}
		$safelist = array("'",'"','/','\\',';','&',')','(');
		foreach($safelist as $key=>$value){
			if(strpos($user,$value) !== false){
				$this->error(P_Lang('会员账号不允许包含字符串：{string}',array('string'=>$value)),$errurl);
			}
		}
		$chk = $this->model('user')->chk_name($user);
		if($chk){
			$this->error(P_Lang('会员账号已存用'),$errurl);
		}
		$newpass = $this->get('newpass');
		if(!$newpass){
			$this->error(P_Lang('密码不能为空'),$errurl);
		}
		$chkpass = $this->get('chkpass');
		if(!$chkpass){
			$this->error(P_Lang('确认密码不能为空'),$errurl);
		}
		if($newpass != $chkpass){
			$this->error(P_Lang('两次输入的密码不一致'),$errurl);
		}
		$email = $this->get('email');
		$mobile = $this->get('mobile');
		if($email){
			$chk = $this->lib('common')->email_check($email);
			if(!$chk){
				$this->error(P_Lang('邮箱不合法'),$errurl);
			}
			$chk = $this->model('user')->user_email($email);
			if($chk){
				$this->error(P_Lang('邮箱已注册'),$errurl);
			}
		}
		if($mobile){
			$chk = $this->lib('common')->tel_check($mobile);
			if(!$chk){
				$this->error(P_Lang('手机号不合法'),$errurl);
			}
			$chk = $this->model('user')->user_mobile($mobile);
			if($chk){
				$this->error(P_Lang('手机号已注册'),$errurl);
			}
		}
		
		$array = array();
		$array["user"] = $user;
		$array["pass"] = password_create($newpass);
		$array['email'] = $email;
		$array['mobile'] = $mobile;
		$array["status"] = 0;
		$array["regtime"] = $this->time;
		$uid = $this->model('user')->save($array);
		if(!$uid){
			$this->error(P_Lang('注册失败，请联系管理员'),$errurl);
		}
		$this->success(P_Lang('注册成功，等待管理员审核'),$this->url);
	}
}
?>