<?php
/*****************************************************************************************
	文件： plugins/sitecopy/uninstall.php
	备注： 网站复制<插件卸载>
	版本： 4.x
	网站： www.phpok.com
	作者： phpok.com
	时间： 2015年11月12日 09时51分
*****************************************************************************************/
class uninstall_sitecopy extends phpok_plugin
{
	public $me;
	public function __construct()
	{
		parent::plugin();
		$this->me = $this->plugin_info();
	}
	//插件卸载时，执行的方法，如删除表，或去除其他一些选项
	public function index()
	{
		//执行一些自定义的动作
	}
	
}