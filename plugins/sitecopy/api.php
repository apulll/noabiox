<?php
/*****************************************************************************************
	文件： plugins/sitecopy/api.php
	备注： 网站复制<接口应用>
	版本： 4.x
	网站： www.phpok.com
	作者： phpok.com
	时间： 2015年11月12日 09时51分
*****************************************************************************************/
class api_sitecopy extends phpok_plugin
{
	public $me;
	public function __construct()
	{
		parent::plugin();
		$this->me = $this->plugin_info();
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
	
}