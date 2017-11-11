<?php
/**
 * 会员中心
 * @package phpok\admin
 * @作者 qinggan <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 4.x
 * @授权 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2017年04月30日
**/

class user_control extends phpok_control
{
	public function __construct()
	{
		parent::control();
	}


	//会员列表
	public function index_f()
	{
		$pageid = $this->get($this->config["pageid"],"int");
		if(!$pageid){
			$pageid = 1;
		}
		$psize = $this->config["psize"];
		if(!$psize){
			$psize = 30;
		}
		$keywords = $this->get("keywords");
		$page_url = $this->url("user");
		$condition = "1=1";
		if($keywords){
			$this->assign("keywords",$keywords);
			$condition .= " AND (user LIKE '%".$keywords."%' OR email LIKE '%".$keywords."%' OR mobile LIKE '%".$keywords."%')";
			$page_url.="&keywords=".rawurlencode($keywords);
		}
		$offset = ($pageid-1) * $psize;
		$rslist = $this->model('user')->get_list($condition,$offset,$psize);
		$count = $this->model('user')->get_count($condition);
		$string = 'home='.P_Lang('首页').'&prev='.P_Lang('上一页').'&next='.P_Lang('下一页').'&last='.P_Lang('尾页').'&half=3';
		$string.= '&add='.P_Lang('数量：').'(total)/(psize)'.P_Lang('，').P_Lang('页码：').'(num)/(total_page)&always=1';
		$pagelist = phpok_page($page_url,$count,$pageid,$psize,$string);
		$this->assign("total",$count);
		$this->assign("rslist",$rslist);
		$this->assign("pagelist",$pagelist);		
		$this->view("user_list");
	}

	public function add_f()
	{
		$this->set_f();
	}

	public function set_f()
	{
		$id = $this->get("id","int");
		$group_id = 0;
		if($id){
			$rs = $this->model('user')->get_one($id);
			$this->assign("rs",$rs);
			$this->assign("id",$id);
		}
		$this->view("user_add");
	}

	public function chk_f()
	{
		$id = $this->get("id","int");
		$user = $this->get("user");
		if(!$user){
			$this->json(P_Lang('会员账号不允许为空'));
		}
		$rs_name = $this->model('user')->chk_name($user,$id);
		if($rs_name){
			$this->json(P_Lang('会员账号已经存在'));
		}
		$mobile = $this->get('mobile');
		if($mobile){
			if(!$this->lib('common')->tel_check($mobile)){
				$this->json(P_Lang('手机号填写不正确'));
			}
			$chk = $this->model('user')->get_one($mobile,'mobile');
			if($id){
				if($chk && $chk['id'] != $id){
					$this->json(P_Lang('手机号已被占用'));
				}
			}else{
				if($chk){
					$this->json(P_Lang('手机号已被占用'));
				}
			}
		}
		$email = $this->get('email');
		if($email){
			if(!$this->lib('common')->email_check($email)){
				$this->json(P_Lang('邮箱填写不正确'));
			}
			$chk = $this->model('user')->get_one($email,'email');
			if($id){
				if($chk && $chk['id'] != $id){
					$this->json(P_Lang('邮箱已被占用'));
				}
			}else{
				if($chk){
					$this->json(P_Lang('邮箱已被占用'));
				}
			}
		}
		$this->json(P_Lang('验证通过'),true);
	}

	//存储信息
	public function setok_f()
	{
		$id = $this->get("id","int");
		$array = array();
		$array["user"] = $this->get("user");
		$array['avatar'] = $this->get('avatar');
		$array['email'] = $this->get('email');
		$array['mobile'] = $this->get('mobile');
		$pass = $this->get("pass");
		if($pass){
			$array["pass"] = password_create($pass);
		}else{
			if(!$id){
				$array["pass"] = password_create("123456");
			}
		}
		$array["status"] = $this->get("status","int");
		$regtime = $this->get("regtime","time");
		if(!$regtime){
			$regtime = $this->time;
		}
		$array["regtime"] = $regtime;
		if($id){
			$this->model('user')->save($array,$id);
			error('会员编辑成功',$this->url('user'),'ok');
		}else{
			$this->model('user')->save($array);
			error('会员添加成功',$this->url('user'),'ok');
		}
	}

	public function ajax_status_f()
	{
		$id = $this->get("id","int");
		if(!$id){
			exit(P_Lang('没有指定ID'));
		}
		$rs = $this->model('user')->get_one($id);
		$status = $rs["status"] ? 0 : 1;
		$this->model('user')->set_status($id,$status);
		exit("ok");
	}

	public function ajax_del_f()
	{
		$id = $this->get("id","int");
		if(!$id){
			exit(P_Lang('未指定ID'));
		}
		$this->model('user')->del($id);
		exit("ok");
	}
}