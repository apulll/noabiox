<?php
/***********************************************************
	Filename: {phpok}/api/post_control.php
	Note	: 存储发布的项目信息
	Version : 4.0
	Web		: www.phpok.com
	Author  : qinggan <qinggan@188.com>
	Update  : 2013年11月11日
***********************************************************/
if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");}
class postnew_control extends phpok_control
{
	public function __construct()
	{
		parent::control();
	}

	public function edit_f()
	{
		$this->save_f();
	}

	public function cbd_f() {
		// $data = $this->get('data');
		$data = $_POST['data'];
		$arr = $this->get('data');

		$array = array();

		$module_id = 82;
		$array["site_id"] = 1;
		$array["project_id"] = 175;
		$array["cate_id"] = 0;
		$array["fullname"] = $arr["fullname"];
		$array["company_name"] = $arr['company_name'];
		$array["email"] = $arr['email'];
		$array["mobile"] = $arr['mobile'];
		$array["content"] = $arr['content'];

		$tmp = array();
		$tmp["title"] = '无';
		$tmp["site_id"] = 1;
		$tmp["project_id"] = 175;
		$tmp["parent_id"] = 0;
		$tmp["module_id"] = 82;
		$tmp["cate_id"] = 0;

		$insert_id = $this->model('list')->save($tmp);
		$array["id"] = $insert_id;

		$get_result = $this->model('list')->save_ext_aaa($array,82);

		// $get_result = $this->model('list')->save_ext($array,82);
		// if($get_result){
		// 	$this->json(P_Lang('编辑失败，请联系管理员'));
		// }


		$this->json(true);
	}
}
?>