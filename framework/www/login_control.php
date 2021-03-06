<?php
/**
 * 会员登录操作，基于WEB模式
 * @package phpok\www
 * @作者 qinggan <admin@phpok.com>
 * @版权 2015-2016 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 4.x
 * @授权 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2016年07月25日
**/

if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");}
class login_control extends phpok_control
{
	public function __construct()
	{
		parent::control();
		$backurl = $this->get('_back');
		if(!$backurl){
			$backurl = $this->config['url'];
		}
		if($this->session->val('user_id')){
			$this->success(P_Lang('您已是本站会员，不需要再次登录'),$backurl);
		}
	}

	/**
	 * 登录页
	 * @参数 _back 返回上一级的页面链接地址
	 * @返回 
	 * @更新时间 
	**/
	public function index_f()
	{
		$backurl = $this->get('_back');
		if(!$backurl){
			$backurl = $this->config['url'];
		}
		$this->assign("_back",$backurl);
		$this->view('login');
	}

	/**
	 * 基于WEB的登录模式，有返回有跳转，适用于需要嵌入第三方HTML代码使用
	 * @参数 _back 返回之前登录后的页面
	 * @参数 _chkcode 验证码，根据实际情况判断是否启用此项
	 * @参数 user 会员账号/邮箱/手机号
	 * @参数 pass 密码
	**/
	public function ok_f()
	{
		$_back = $this->get("_back");
		if(!$_back){
			$_back = $this->config['url'];
			$error_url = $this->url('login');
		}else{
			$error_url = $this->url('login','','_back='.rawurlencode($_back));
		}
		if($this->session->val('user_id')){
			$this->success(P_Lang('您已是本站会员，不需要再次登录'),$_back);
		}
		if($this->config['is_vcode'] && function_exists('imagecreate')){
			$code = $this->get('_chkcode');
			if(!$code){
				$this->error(P_Lang('验证码不能为空'),$error_url);
			}
			$code = md5(strtolower($code));
			if($code != $this->session->val('vcode')){
				$this->error(P_Lang('验证码填写不正确'),$error_url);
			}
			$this->session->unassign('vocode');
		}
		//获取登录信息
		$user = $this->get("user");
		if(!$user){
			$this->error(P_Lang('账号不能为空'),$error_url);
		}
		$pass = $this->get("pass");
		if(!$pass){
			$this->error(P_Lang('会员密码不能为空'),$error_url);
		}
		//多种登录方式
		$user_rs = $this->model('user')->get_one($user,'user');
		if(!$user_rs){
			$user_rs = $this->model('user')->get_one($user,'email');
			if(!$user_rs){
				$user_rs = $this->model('user')->get_one($user,'mobile');
				if(!$user_rs){
					$this->error(P_Lang('会员信息不存在'),$error_url);
				}
			}
		}
		if(!$user_rs['status']){
			$this->error(P_Lang('会员审核中，暂时不能登录'),$error_url);
		}
		if($user_rs['status'] == '2'){
			$this->error(P_Lang('会员被管理员锁定，请联系管理员解锁'),$error_url);
		}
		if(!password_check($pass,$user_rs["pass"])){
			$this->error(P_Lang('登录密码不正确'),$error_url);
		}
		$this->session->assign('user_id',$user_rs['id']);
		$this->session->assign('user_name',$user_rs['user']);
		$this->success(P_Lang('会员登录成功'),$_back);
	}

	/**
	 * 弹出窗口登录页
	**/
	public function open_f()
	{
		if($this->session->val('user_id')){
			$this->error(P_Lang('您已是本站会员，不需要再次登录'));
		}
		$this->view("login_open");
	}

}