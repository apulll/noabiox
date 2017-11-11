<?php
/*****************************************************************************************
	文件： plugins/sitecopy/admin.php
	备注： 网站复制<后台应用>
	版本： 4.x
	网站： www.phpok.com
	作者： phpok.com
	时间： 2015年11月12日 09时51分
*****************************************************************************************/
class admin_sitecopy extends phpok_plugin
{
	public $me;
	public function __construct()
	{
		parent::plugin();
		$this->me = $this->plugin_info();
		set_time_limit(0);
	}
	//全局运行插件，在执行当前方法运行前，调整参数
	public function phpok_before()
	{
		//编写代码;
	}
	//全局运行插件，在执行当前方法运行后，数据未输出前
	public function phpok_after()
	{
		//编写代码;
	}

	public function html_all_add_phpokbody()
	{
		$siteinfo = $this->model('site')->get_one($this->me['param']['sitecopy_id']);
		if($siteinfo){
			$this->tpl->assign('ext_siteinfo',$siteinfo);
			$this->show_tpl('create_add_select.html');
		}
	}

	public function html_site_index_body()
	{
		$sites = $this->model('site')->get_all_site();
		if($sites && count($sites) > 1){
			$this->show_tpl('copy_site_button.html');
		}
	}

	public function copyit()
	{
		$sitelist = $this->model('site')->get_all_site();
		$this->assign('sitelist',$sitelist);
		$this->echo_tpl('copy_site.html');
	}

	public function startcopy()
	{
		$site1 = $this->get('site1','int');
		$site2 = $this->get('site2','int');
		$startid = $this->get('startid','int');
		$nextid = $this->get('nextid','int');
		if(!$site1){
			$this->json('未指定来源站点');
		}
		if(!$site2){
			$this->json('未指定目标站点');
		}
		if($site1 == $site2){
			$this->json('来源站点和目标站点一致，不能执行复制');
		}
		$ids = $this->get('ids');
		if(!$ids){
			$this->json('未指定要复制的项目');
		}
		$list = explode(",",$ids);
		if(!$list[$startid]){
			$chk_next_startid = $startid+1;
			$data = array('content'=>'无法获取要复制的类型');
			$data['end'] = !$list[$chk_next_startid] ? true : false;
			if(!$data['end']){
				$data['content'] .= "，正在进入下一环节，请稍候…";
			}
			$data['startid'] = $startid;
			$data['nextid'] = $nextid;
			$this->json($data,true);
		}
		$name = "exec_".$list[$startid];
		$rs = $this->$name($site1,$site2,$nextid);
		if(!$rs || !$rs['status']){
			$info = ($rs && $rs['content']) ? $rs['content'] : '执行操作失败，请检查…';
			$this->json($info);
		}
		$nextid = $rs['nextid'];
		if(!$nextid){
			$chk_next_startid = $startid+1;
			if(!$list[$chk_next_startid]){
				$rs['end'] = true;
			}
			$startid = $chk_next_startid;
		}
		$data = array('content'=>$rs['content'],'end'=>$rs['end'],'startid'=>$startid,'nextid'=>$nextid);
		$this->json($data,true);
	}

	//站点信息复制
	private function exec_siteinfo($site1,$site2,$nextid=0)
	{
		$sql = "SELECT * FROM ".$this->db->prefix."site WHERE id='".$site1."'";
		$rs = $this->db->get_one($sql);
		if(!$rs){
			return array('content'=>'网站信息不存在');
		}
		$data = array('dir'=>$rs['dir'],'status'=>$rs['status'],'content'=>$rs['content'],'tpl_id'=>$rs['tpl_id']);
		$data['logo'] = $rs['logo'];
		$tmp_api_code = $rs['api_code'] ? $rs['api_code'] : rand(1000,9999);
		$data['api_code'] = substr(md5($tmp_api_code),rand(0,10),rand(10,22));
		$data['seo_title'] = $rs['seo_title'];
		$data['seo_keywords'] = $rs['seo_keywords'];
		$data['seo_desc'] = $rs['seo_desc'];
		$data['lang'] = $rs['lang'];
		$this->model('site')->save($data,$site2);
		//删除已存在的扩展
		$rslist = $this->model('site')->all_list($site2);
		if($rslist){
			foreach($rslist as $key=>$value){
				$this->model('ext')->del('all-'.$value['id']);
			}
			$sql = "DELETE FROM ".$this->db->prefix."all WHERE site_id='".$site2."'";
			$this->db->query($sql);
		}
		//增加扩展		
		$alist = $this->model('site')->all_list($site1);
		if($alist){
			foreach($alist as $key=>$value){
				$data = $value;
				unset($data['id']);
				$data['site_id'] = $site2;
				$insert_id = $this->model('site')->all_save($data);
				if($insert_id){
					$this->save_ext($value['id'],$insert_id,'all');
				}
			}
		}
		$array = array('content'=>'网站基本信息复制成功','end'=>false,'nextid'=>0,'status'=>true);
		return $array;
	}

	private function exec_project($site1,$site2,$nextid=0)
	{
		//删除现有分类及其扩展
		$sql = "SELECT id FROM ".$this->db->prefix."cate WHERE site_id='".$site2."'";
		$rslist = $this->db->get_all($sql);
		if($rslist){
			foreach($rslist as $key=>$value){
				$this->model('ext')->del('cate-'.$value['id']);
			}
			$sql = "DELETE FROM ".$this->db->prefix."cate WHERE site_id='".$site2."'";
			$this->db->query($sql);
		}
		$sql = "SELECT * FROM ".$this->db->prefix."cate WHERE site_id='".$site1."' ORDER BY id ASC";
		$rslist = $this->db->get_all($sql,'id');
		if($rslist){
			foreach($rslist as $key=>$value){
				$data = $value;
				unset($data['id'],$data['parent_id']);
				$data['site_id'] = $site2;
				$insert_id = $this->model('cate')->save($data);
				if($insert_id){
					$this->save_ext($value['id'],$insert_id,'cate');
					if($data['tag']){
						$this->model('tag')->update_tag($data['tag'],'c'.$insert_id,$new_id);
					}
				}
			}
			//更新层级关系
			foreach($rslist as $key=>$value){
				if(!$value['parent_id']){
					continue;
				}
				$identifier = $rslist[$value['parent_id']]['identifier'];
				if(!$identifier){
					continue;
				}
				$sql = "SELECT id FROM ".$this->db->prefix."cate WHERE site_id='".$site2."' AND identifier='".$identifier."'";
				$rs = $this->db->get_one($sql);
				if(!$rs || !$rs['id']){
					continue;
				}
				$sql = "UPDATE ".$this->db->prefix."cate SET parent_id='".$rs['id']."' WHERE site_id='".$site2."' AND identifier='".$value['identifier']."'";
				$this->db->query($sql);
			}
		}
		//删除现有项目
		$sql = "SELECT id FROM ".$this->db->prefix."project WHERE site_id='".$site2."'";
		$rslist = $this->db->get_all($sql);
		if($rslist){
			foreach($rslist as $key=>$value){
				$this->model('ext')->del('project-'.$value['id']);
			}
			$sql = "DELETE FROM ".$this->db->prefix."project WHERE site_id='".$site2."'";
			$this->db->query($sql);
		}
		//复制项目信息
		$rslist = $this->model('project')->project_all($site1,'id');
		if($rslist){
			foreach($rslist as $key=>$value){
				$data = $value;
				unset($data['id'],$data['parent_id']);
				$data['site_id'] = $site2;
				$data['cate'] = 0;
				if($value['cate']){
					$sql = "SELECT identifier FROM ".$this->db->prefix."cate WHERE id='".$value['cate']."'";
					$tmp = $this->db->get_one($sql);
					if($tmp && $tmp['identifier']){
						$sql = "SELECT id FROM ".$this->db->prefix."cate WHERE identifier='".$tmp['identifier']."' AND site_id='".$site2."'";
						$tmp_rs = $this->db->get_one($sql);
						if($tmp_rs && $tmp_rs['id']){
							$data['cate'] = $tmp_rs['id'];
						}
					}
				}
				$data['freight'] = 0;
				$insert_id = $this->model('project')->save($data);
				if($insert_id){
					$this->save_ext($value['id'],$insert_id,'project');
					if($data['tag']){
						$this->model('tag')->update_tag($data['tag'],'c'.$insert_id,$site2);
					}
				}
			}
			//更新层级关系
			foreach($rslist as $key=>$value){
				if(!$value['parent_id']){
					continue;
				}
				$tmp = $rslist[$value['parent_id']]['identifier'];
				$sql = "SELECT id FROM ".$this->db->prefix."project WHERE site_id='".$site2."' AND identifier='".$tmp."'";
				$tmp_rs = $this->db->get_one($sql);
				if(!$tmp_rs || !$tmp_rs['id']){
					continue;
				}
				$sql = "UPDATE ".$this->db->prefix."project SET parent_id='".$tmp_rs['id']."' WHERE site_id='".$site2."' AND identifier='".$value['identifier']."'";
				$this->db->query($sql);
			}
		}
		$array = array('content'=>'项目及分类信息复制成功','end'=>false,'nextid'=>0,'status'=>true);
		return $array;
	}

	private function exec_email($site1,$site2,$nextid=0)
	{
		$sql = "DELETE FROM ".$this->db->prefix."email WHERE site_id='".$site2."'";
		$this->db->query($sql);
		$sql = "SELECT * FROM ".$this->db->prefix."email WHERE site_id='".$site1."'";
		$rslist = $this->db->get_all($sql);
		if($rslist){
			foreach($rslist as $key=>$value){
				unset($value['id']);
				$value['site_id'] = $site2;
				$value['title'] = addslashes($value['title']);
				$value['content'] = addslashes($value['content']);
				$this->model('email')->save($value);
			}
		}
		$array = array('content'=>'通知模板复制成功','end'=>false,'nextid'=>0,'status'=>true);
		return $array;
	}

	private function exec_rewrite($site1,$site2,$nextid=0)
	{
		$file = $this->dir_root.'data/xml/rewrite_'.$site1.'.xml';
		if(!file_exists($file)){
			$array = array('content'=>'伪静态页文件不存在','end'=>false,'nextid'=>0,'status'=>false);
			return $array;
		}
		$this->lib('file')->cp($file,$this->dir_root.'data/xml/rewrite_'.$site2.'.xml');
		$array = array('content'=>'伪静态页规则复制成功','end'=>false,'nextid'=>0,'status'=>true);
		return $array;
	}

	private function exec_data($site1,$site2,$nextid=0)
	{
		$sql = "DELETE FROM ".$this->db->prefix."phpok WHERE site_id='".$site2."'";
		$this->db->query($sql);
		//读取项目，分类等信息
		$sql = "SELECT id,site_id,identifier FROM ".$this->db->prefix."project";
		$tmplist = $this->db->get_all($sql);
		if(!$tmplist){
			$array = array('content'=>'项目信息不存在','end'=>false,'nextid'=>0,'status'=>false);
			return $array;
		}
		$plist = array();
		foreach($tmplist as $key=>$value){
			$plist[$value['site_id']][$value['identifier']] = $value['id'];
		}
		if(!$plist[$site2]){
			$array = array('content'=>'目标网站的项目内容为空','end'=>false,'nextid'=>0,'status'=>false);
			return $array;
		}
		if(!$plist[$site1]){
			$array = array('content'=>'源网站的项目内容为空','end'=>false,'nextid'=>0,'status'=>false);
			return $array;
		}
		$project = array();
		foreach($plist[$site1] as $key=>$value){
			if($plist[$site2][$key]){
				$project[$value] = $plist[$site2][$key];
			}
		}
		if(!$project){
			$array = array('content'=>'两个站点的项目信息无法匹配','end'=>false,'nextid'=>0,'status'=>false);
			return $array;
		}
		$cate = array();
		$sql = "SELECT id,site_id,identifier FROM ".$this->db->prefix."cate";
		$tmplist = $this->db->get_all($sql);
		if($tmplist){
			$clist = array();
			foreach($tmplist as $key=>$value){
				$clist[$value['site_id']][$value['identifier']] = $value['id'];
			}
			if($clist[$site2] && $clist[$site1]){
				foreach($clist[$site1] as $key=>$value){
					$cate[$value] = $clist[$site2][$key];
				}
			}
		}
		$sql = "SELECT * FROM ".$this->db->prefix."phpok WHERE site_id='".$site1."'";
		$rslist = $this->db->get_all($sql);
		if(!$rslist){
			$array = array('content'=>'源站点没有数据调用信息','end'=>false,'nextid'=>0,'status'=>false);
			return $array;
		}
		foreach($rslist as $key=>$value){
			$data = $value;
			unset($data['id']);
			$data['site_id'] = $site2;
			$data['pid'] = 0;
			$data['cateid'] = 0;
			if($value['pid']){
				$data['pid'] = $project[$value['pid']];
				if(!$data['pid']){
					continue;
				}
			}
			if($value['cateid']){
				$data['cateid'] = $cate[$value['cateid']];
			}
			if($data['ext']){
				$data['ext'] = addslashes($data['ext']);
			}
			$this->model('call')->save($data);
		}
		$array = array('content'=>'数据调用复制成功','end'=>false,'nextid'=>0,'status'=>true);
		return $array;
	}

	private function exec_list($site1,$site2,$nextid=0)
	{
		$sql = "SELECT count(id) FROM ".$this->db->prefix."list WHERE site_id='".$site1."' AND parent_id=0";
		$total = $this->db->count($sql);
		if(!$total){
			$array = array('content'=>'没有内容可以复制的','end'=>true,'nextid'=>0,'status'=>false);
			return $array;
		}
		$sql = "SELECT * FROM ".$this->db->prefix."list WHERE site_id='".$site1."' AND parent_id=0 ORDER BY id ASC LIMIT ".$nextid.",1";
		$rs = $this->db->get_one($sql);
		if(!$rs){
			$array = array('content'=>'内容复制完毕','end'=>true,'nextid'=>0,'status'=>true);
			return $array;
		}
		$tip = '共有主题数：<span class="red">'.$total.'</span>，已复制数：'.($nextid+1);
		//检查内容是否已存在
		if($rs['identifier']){
			$sql = "SELECT id FROM ".$this->db->prefix."list WHERE site_id='".$site2."' AND identifier='".$rs['identifier']."'";
			$tmp = $this->db->get_one($sql);
			if($tmp){
				$tip .= '，当前主题：<span class="red">'.$rs['title'].'</span> 已存在，跳过复制';
				$array = array('content'=>$tip,'end'=>false,'nextid'=>($nextid+1),'status'=>true);
				return $array;
			}
		}
		$data = $rs;
		unset($data['id']);
		$data['site_id'] = $site2;
		$data['parent_id'] = 0;
		$data['cate_id'] = 0;
		$sql = "SELECT identifier FROM ".$this->db->prefix."project WHERE id='".$rs['project_id']."'";
		$tmp = $this->db->get_one($sql);
		if(!$tmp){
			$tip .= '，当前主题：<span class="red">'.$rs['title'].'</span> 绑定的项目异常，跳过复制';
			$array = array('content'=>$tip,'end'=>false,'nextid'=>($nextid+1),'status'=>true);
			return $array;
		}
		$sql = "SELECT id FROM ".$this->db->prefix."project WHERE site_id='".$site2."' AND identifier='".$tmp['identifier']."'";
		$tmp = $this->db->get_one($sql);
		if(!$tmp){
			$tip .= '，当前主题：<span class="red">'.$rs['title'].'</span> 新项目未创建，跳过复制';
			$array = array('content'=>$tip,'end'=>false,'nextid'=>($nextid+1),'status'=>true);
			return $array;
		}
		$data['project_id'] = $tmp['id'];
		if($rs['cate_id']){
			$sql = "SELECT identifier FROM ".$this->db->prefix."cate WHERE id='".$rs['cate_id']."'";
			$tmp = $this->db->get_one($sql);
			if($tmp){
				$sql = "SELECT id FROM ".$this->db->prefix."cate WHERE identifier='".$tmp['identifier']."' AND site_id='".$site2."'";
				$tmp = $this->db->get_one($sql);
				if($tmp){
					$data['cate_id'] = $tmp['id'];
				}
			}
		}
		$data['title'] = addslashes($data['title']);
		$insert_id = $this->model('list')->save($data);
		if(!$insert_id){
			$tip .= '，当前主题：<span class="red">'.$rs['title'].' 复制失败</span>';
			$array = array('content'=>$tip,'end'=>false,'nextid'=>($nextid+1),'status'=>true);
			return $array;
		}

		if($data['tag']){
			$this->model('tag')->update_tag($data['tag'],$insert_id,$site2);
		}
		$main_data = $data;

		//更新扩展表信息
		$sql = "SELECT * FROM ".$this->db->prefix."list_".$rs['module_id']." WHERE id='".$rs['id']."'";
		$ext_rs = $this->db->get_one($sql);
		if($ext_rs){
			foreach($ext_rs as $key=>$value){
				$ext_rs[$key] = addslashes($value);
			}
			$ext_data = $ext_rs;
			$ext_data['id'] = $insert_id;
			$ext_data['site_id'] = $site2;
			$ext_data['project_id'] = $data['project_id'];
			$this->model('list')->save_ext($ext_data,$rs['module_id']);
		}
		
		if($rs['cate_id']){
			$sql = "SELECT id,identifier,site_id FROM ".$this->db->prefix."cate";
			$tmplist = $this->db->get_all($sql);
			$cate = array();
			if($tmplist){
				foreach($tmplist as $key=>$value){
					$cate[$value['site_id']][$value['identifier']] = $value['id'];
				}
			}
			$clist = array();
			foreach($cate[$site1] as $key=>$value){
				if($cate[$site2][$key]){
					$clist[$value] = $cate[$site2][$key];
				}
			}
			//保存扩展分类
			$sql = "SELECT cate_id FROM ".$this->db->prefix."list_cate WHERE id='".$rs['id']."'";
			$tmplist = $this->db->get_all($sql);
			if($tmplist){
				foreach($tmplist as $k=>$v){
					$cateid = $clist[$v['cate_id']];
					if($cateid){
						$this->model('list')->list_cate_add($cateid,$insert_id);
					}
				}
			}
		}

		//更新主题自身扩展
		$sql = "SELECT * FROM ".$this->db->prefix."ext WHERE module='list-".$rs['id']."'";
		$elist = $this->db->get_all($sql);
		if($elist){
			foreach($elist as $key=>$value){
				$data = $value;
				unset($data['id']);
				$data['module'] = 'list-'.$insert_id;
				$data['title'] = addslashes($data['title']);
				if($data['note']){
					$data['note'] = addslashes($data['note']);
				}
				if($data['ext']){
					$data['ext'] = addslashes($data['ext']);
				}
				$nid = $this->model('ext')->save($data);
				if($nid){
					$sql = "SELECT content FROM ".$this->db->prefix."extc WHERE id='".$value['id']."'";
					$tmpc = $this->db->get_one($sql);
					if($tmpc && $tmpc['content']){
						$content = addslashes($tmpc['content']);
						$this->model('ext')->content_save($content,$nid);
					}
				}
			}
		}
		$tip .= '，当前主题：<span class="darkblue">'.$rs['title'].' 复制成功</span>';
		//检测是否有子主题
		$this->_copy_sublist($rs['id'],$insert_id,$main_data);
		$array = array('content'=>$tip,'end'=>false,'nextid'=>($nextid+1),'status'=>true);
		return $array;
	}

	private function _copy_sublist($old_id,$new_id,$newdata)
	{
		$sql = "SELECT * FROM ".$this->db->prefix."list WHERE parent_id='".$old_id."'";
		$rslist = $this->db->get_all($sql);
		if(!$rslist){
			return false;
		}
		foreach($rslist as $key=>$value){
			$data = $value;
			unset($data['id']);
			$data['site_id'] = $newdata['site_id'];
			$data['parent_id'] = $new_id;
			$data['project_id'] = $newdata['project_id'];
			$data['module_id'] = $newdata['module_id'];
			$data['cate_id'] = $newdata['cate_id'];
			$data['title'] = addslashes($data['title']);
			$insert_id = $this->model('list')->save($data);
			if(!$insert_id){
				continue;
			}

			if($data['tag']){
				$this->model('tag')->update_tag($data['tag'],$insert_id,$newdata['site_id']);
			}

			//更新扩展表信息
			$sql = "SELECT * FROM ".$this->db->prefix."list_".$newdata['module_id']." WHERE id='".$value['id']."'";
			$ext_rs = $this->db->get_one($sql);
			if($ext_rs){
				foreach($ext_rs as $k=>$v){
					$ext_rs[$k] = addslashes($v);
				}
				$ext_data = $ext_rs;
				$ext_data['id'] = $insert_id;
				$ext_data['site_id'] = $newdata['site_id'];
				$ext_data['project_id'] = $newdata['project_id'];
				$this->model('list')->save_ext($ext_data,$newdata['module_id']);
			}
			
			if($data['cate_id']){
				$this->model('list')->list_cate_add($data['cate_id'],$insert_id);
			}
			

			//更新主题自身扩展
			$sql = "SELECT * FROM ".$this->db->prefix."ext WHERE module='list-".$value['id']."'";
			$elist = $this->db->get_all($sql);
			if($elist){
				foreach($elist as $k=>$v){
					$data = $v;
					unset($data['id']);
					$data['module'] = 'list-'.$insert_id;
					$data['title'] = addslashes($data['title']);
					if($data['note']){
						$data['note'] = addslashes($data['note']);
					}
					if($data['ext']){
						$data['ext'] = addslashes($data['ext']);
					}
					$nid = $this->model('ext')->save($data);
					if($nid){
						$sql = "SELECT content FROM ".$this->db->prefix."extc WHERE id='".$v['id']."'";
						$tmpc = $this->db->get_one($sql);
						if($tmpc && $tmpc['content']){
							$content = addslashes($tmpc['content']);
							$this->model('ext')->content_save($content,$nid);
						}
					}
				}
			}
		}
		return true;
	}

	private function exec_tpl($site1,$site2,$nextid=0)
	{
		$sql = "SELECT * FROM ".$this->db->prefix."site WHERE id='".$site1."'";
		$rs = $this->db->get_one($sql);
		if(!$rs){
			return array('content'=>'网站信息不存在');
		}
		$tpl_rs = $this->model('tpl')->get_one($rs['tpl_id']);
		$tplfolder = "site".$site2;
		$this->_rcopy($this->dir_root.'tpl/'.$tpl_rs['folder'],$this->dir_root.'tpl/'.$tplfolder);
		$data = $tpl_rs;
		unset($data['id']);
		$data['folder'] = $tplfolder;
		$data['title'] = '风格-'.$site2;
		$insert_id = $this->model('tpl')->save($data);
		$sql = "UPDATE ".$this->db->prefix."site SET tpl_id='".$insert_id."' WHERE id='".$site2."'";
		$this->db->query($sql);
		$tip = '网站模板复制成功';
		$array = array('content'=>$tip,'end'=>true,'nextid'=>0,'status'=>true);
		return $array;
	}

	private function _rcopy($src, $dst)
	{
		if (file_exists($dst)){
			return true;
		}
		if(is_dir($src)){
			mkdir($dst);
			$files = scandir($src);
			foreach ($files as $file){
				if ($file != "." && $file != ".."){
					$this->_rcopy($src."/".$file, $dst."/".$file);
				}
			}
		}else if(file_exists($src)){
			copy($src, $dst);
		}
		return true;
 	}


	private function exec_clean($site1,$site2,$nextid=0)
	{
		//删除主题操作
		$sql = "SELECT id,module_id FROM ".$this->db->prefix."list WHERE site_id='".$site2."'";
		$rslist = $this->db->get_all($sql);
		if(!$rslist){
			$tip = '没有要清理的主题';
			$array = array('content'=>$tip,'end'=>true,'nextid'=>0,'status'=>true);
			return $array;
		}
		foreach($rslist as $key=>$value){
			$this->model('list')->delete($value['id'],$value['module_id']);
		}
		$tip = '主题清理完成';
		$array = array('content'=>$tip,'end'=>true,'nextid'=>0,'status'=>true);
		return $array;
	}
	
	public function ap_all_addok()
	{
		if(!$this->me['param']['sitecopy_id']){
			return false;
		}
		$sql = "SELECT max(id) as id FROM ".$this->db->prefix."site";
		$tmp = $this->db->get_one($sql);
		if(!$tmp || $tmp['id'] == $_SESSION['admin_site_id']){
			return false;
		}
		$new_id = $tmp['id'];
		$old_id = $this->me['param']['sitecopy_id'];
		//复制站点数据
		if(!$this->me['param']['sitecopy_data']){
			return true;
		}
		foreach($rslist as $key=>$value){
			$data = $value;
			unset($data['id'],$data['parent_id']);
			$data['site_id'] = $new_id;
			if($value['cate_id']){
				$data['cate_id'] = $clist[$value['cate_id']];
			}
			$data['project_id'] = $plist[$value['project_id']];
			$data['title'] = addslashes($value['title']);
			$insert_id = $this->model('list')->save($data);
			if(!$insert_id){
				continue;
			}
			//更新Tag
			if($data['tag']){
				$this->model('tag')->update_tag($data['tag'],$insert_id,$new_id);
			}			
			//保存扩展分类
			$sql = "SELECT cate_id FROM ".$this->db->prefix."list_cate WHERE id='".$value['id']."'";
			$tmplist = $this->db->get_all($sql);
			if($tmplist){
				foreach($tmplist as $k=>$v){
					$cateid = $clist[$v['cate_id']];
					if($cateid){
						$this->model('list')->list_cate_add($cateid,$insert_id);
					}
				}
			}
			//保存电商数据
			$sql = "SELECT * FROM ".$this->db->prefix."list_biz WHERE id='".$value['id']."'";
			$tmplist = $this->db->get_all($sql);
			if($tmplist){
				foreach($tmplist as $k=>$v){
					$data = $v;
					$data['id'] = $insert_id;
					$this->model('list')->biz_save($save);
				}
			}
			//保存扩展字段对应的数据
			$sql = "SELECT * FROM ".$this->db->prefix."list_".$value['module_id']." WHERE id='".$value['id']."'";
			$tmp = $this->db->get_one($sql);
			if($tmp){
				$tmp['id'] = $insert_id;
				$tmp['site_id'] = $new_id;
				$tmp['project_id'] = $plist[$tmp['project_id']];
				if($tmp['cate_id']){
					$tmp['cate_id'] = $clist[$tmp['cate_id']];
				}
				foreach($tmp as $k=>$v){
					if(!in_array($k,array('id','site_id','project_id','cate_id')) && $v){
						$tmp[$k] = addslashes($v);
					}
				}
				$this->model('list')->save_ext($tmp,$value['module_id']);
			}
		}
	}

	private function save_ext($pid=0,$nid=0,$type='project')
	{
		if(!$nid || !$pid){
			return false;
		}
		$extlist = $this->model('ext')->ext_all($type.'-'.$pid,false);
		if(!$extlist){
			return false;
		}
		foreach($extlist as $key=>$value){
			$ext = $value['ext'] ? unserialize($value['ext']) : array();
			$data = $value;
			unset($data['id']);
			$data['module'] = $type.'-'.$nid;
			$data['ext'] = serialize($ext);
			$info_id = $this->model('ext')->save($data);
			$sql = "SELECT content FROM ".$this->db->prefix."extc WHERE id='".$value['id']."'";
			$tmp = $this->db->get_one($sql);
			if(!$tmp || !$tmp['content']){
				continue;
			}
			$this->model('ext')->content_save(addslashes($tmp['content']),$info_id);
		}
		return true;
	}
}