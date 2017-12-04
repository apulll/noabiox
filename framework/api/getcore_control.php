<?php
/***********************************************************
	Filename: {phpok}/api/res_control.php
	Note	: 附件相关信息
	Version : 4.0
	Web		: www.phpok.com
	Author  : qinggan <qinggan@188.com>
	Update  : 2013年12月4日
***********************************************************/
if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");}
class getcore_control extends phpok_control
{
	public function __construct()
	{
		parent::control();
	}

	
	//返回JS数据
	public function get_core_detail_f()
	{
		$id = $this->get("id");
		$mid = $this->get("mid");
		if(!$id){
			$this->json(P_Lang('未指定ID'));
		}
		
		
		$rslist = $this->model("list")->get_core_detail($mid, $id);
		if($rslist){
			$this->json($rslist,true);
		}
		$this->json("详情获取失败");
	}
}
?>