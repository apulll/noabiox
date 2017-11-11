<?php
/***********************************************************
	Filename: {$phpok}/model/user.php
	Note	: 会员模块
	Version : 3.0
	Author  : qinggan
	Update  : 2013年5月4日
***********************************************************/
class user_model_base extends phpok_model
{
	public $psize = 20;
	public function __construct()
	{
		parent::model();
	}

	public function __destruct()
	{
		parent::__destruct();
		unset($this);
	}

	public function get_one($id,$field='id')
	{
		if(!$id){
			return false;
		}
		if(!$field){
			$field = 'id';
		}
		$sql = " SELECT * FROM ".$this->db->prefix."user ";
		$sql.= " WHERE `".$field."`='".$id."'";
		return $this->db->get_one($sql);
	}

	public function get_list($condition="",$offset=0,$psize=30)
	{

		$sql = " SELECT * FROM ".$this->db->prefix."user ";
		if($condition){
			$sql .= " WHERE ".$condition;
		}
		$offset = intval($offset);
		$psize = intval($psize);
		$sql.= " ORDER BY id DESC ";
		if($psize){
			$offset = intval($offset);
			$sql .= "LIMIT ".$offset.",".$psize;
		}
		return $this->db->get_all($sql,"id");
	}


	//取得总数量
	public function get_count($condition="")
	{
		$sql = "SELECT count(id) FROM ".$this->db->prefix."user ";
		if($condition){
			$sql .= " WHERE ".$condition;
		}
		return $this->db->count($sql);
	}


	//检测账号是否冲突
	public function chk_name($name,$id=0)
	{
		$sql = "SELECT * FROM ".$this->db->prefix."user WHERE user='".$name."' ";
		if($id){
			$sql.= " AND id!='".$id."' ";
		}
		return $this->db->get_one($sql);
	}

	public function uid_from_email($email,$id="")
	{
		if(!$email){
			return false;
		}
		$sql = "SELECT id FROM ".$this->db->prefix."user WHERE email='".$email."'";
		if($id){
			$sql.= " AND id !='".$id."'";
		}
		$rs = $this->db->get_one($sql);
		if(!$rs){
			return false;
		}
		return $rs['id'];
	}

	public function save($data,$id=0)
	{
		if($id){
			$status = $this->db->update_array($data,"user",array("id"=>$id));
			if($status){
				return $id;
			}
			return false;
		}else{
			return $this->db->insert_array($data,"user");
		}
	}


	//更新会员头像
	function update_avatar($file,$uid)
	{
		$sql = "UPDATE ".$this->db->prefix."user SET avatar='".$file."' WHERE id='".$uid."'";
		return $this->db->query($sql);
	}
	
}