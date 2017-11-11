<?php
/*****************************************************************************************
	文件： plugins/sitecopy/install.php
	备注： 网站复制<插件安装>
	版本： 4.x
	网站： www.phpok.com
	作者： phpok.com
	时间： 2015年11月12日 09时51分
*****************************************************************************************/
class install_sitecopy extends phpok_plugin
{
	public $me;
	public function __construct()
	{
		parent::plugin();
		$this->me = $this->plugin_info();
	}
	//插件安装时，增加的扩展表单输出项
	public function index()
	{
		$sitelist = $this->model('site')->get_all_site();
		$this->assign('sitelist',$sitelist);
		return $this->plugin_tpl('setting.html');
	}
	//插件配置参数时，保存扩展参数
	public function save()
	{
		$id = $this->plugin_id();
		$ext = array();
		$ext['sitecopy_id'] = $this->get('sitecopy_id');
		$ext['sitecopy_data'] = $this->get('sitecopy_data');
		$this->plugin_save($ext,$id);
	}
	
}