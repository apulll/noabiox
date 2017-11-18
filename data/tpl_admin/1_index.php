<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Expires" content="wed, 26 feb 1997 08:21:57 GMT" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php if($config['title']){ ?><?php echo $config['title'];?> - <?php } ?><?php echo P_Lang("后台管理");?></title>
	<link href="css/admin-index.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/window.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/artdialog.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/icomoon.css?version=<?php echo $version;?>" />
	<script type="text/javascript" src="<?php echo phpok_url(array('ctrl'=>'js','ext'=>'admin.index'));?>"></script>
	<?php echo $GLOBALS["app"]->plugin_html_ap("head");?>
<?php echo $app->plugin_html_ap("phpokhead");?></head>

<body>
<div class="header">
	<div class="logo"><a href="<?php echo $sys['admin_file'];?>" title="<?php echo $config['title'];?>"><img src="<?php echo $config['adm_logo29'] ? $config['adm_logo29'] : 'images/logo.jpg';?>" alt="<?php echo $config['title'];?>" height="45px" /></a></div>
	<div class="head_user head_tool" onclick="javascript:phpok_admin_logout();void(0);" title="<?php echo P_Lang("管理员退出");?>"><img class="head_user_img" src="images/logout.png" alt="<?php echo P_Lang("管理员退出");?>" /></div>
	<div class="head_tool head_list" id="top-menu-icon">
		<a href="javascript:;" class="head_list_link" id="top-menu-a" title="<?php echo P_Lang("功能菜单");?>"></a>
		<div class="header-tc-content" id="top-menu">
			<span class="header-tc-ct-bg"></span>
			<ul class="first_ul">
				<?php $menulist_id["num"] = 0;$menulist=is_array($menulist) ? $menulist : array();$menulist_id["total"] = count($menulist);$menulist_id["index"] = -1;foreach($menulist AS $key=>$value){ $menulist_id["num"]++;$menulist_id["index"]++; ?>
				<li<?php if($menulist_id['num'] == $menulist_id['total']){ ?> class="laster_line"<?php } ?> name="subtree">
					<a href="javascript:void(0);" ><?php echo P_Lang($value['title']);?></a>
					<div class="second_ul" style="display:none;">
						<span class="arrow_right"></span>
						<ul>
							<?php $sub_id["num"] = 0;$value['sublist']=is_array($value['sublist']) ? $value['sublist'] : array();$sub_id["total"] = count($value['sublist']);$sub_id["index"] = -1;foreach($value['sublist'] AS $k=>$v){ $sub_id["num"]++;$sub_id["index"]++; ?>
							<li<?php if($sub_id['num'] == $sub_id['total']){ ?> class="laster_line"<?php } ?>><a href="javascript:$.win('<?php echo P_Lang($v['title']);?>','<?php echo $v['url'];?>')"><?php echo P_Lang($v['title']);?></a></li>
							<?php } ?>
						</ul>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="head_tool head_desktop"><a href="javascript:$.desktop.tohome();void(0);" class="head_desktop_link" title="<?php echo P_Lang("显示桌面");?>"></a></div>
	<div class="head_tool head_config"><a href="javascript:phpok_admin_control();void(0);" class="head_config_link" title="<?php echo P_Lang("修改个人信息");?>"></a></div>
	<div class="head_web">
		<span class="clear_cache" onclick="phpok_admin_clear()"><?php echo P_Lang("清空缓存");?></span>
		<span class="gohome"><a href="<?php echo $sys['www_file'];?>?siteId=<?php echo $session['admin_site_id'];?>" target="_blank" title="<?php echo P_Lang("访问网站");?>"><?php echo P_Lang("访问网站");?></a></span>
		<?php if($sitelist && count($sitelist)>1){ ?>
		<span class="leftspan"><?php echo P_Lang("网站：");?></span>
		<select class="web_select" name="top_site_id" id="top_site_id" onchange="goto_site(this.value,<?php echo $session['admin_site_id'];?>)">
			<?php $sitelist_id["num"] = 0;$sitelist=is_array($sitelist) ? $sitelist : array();$sitelist_id["total"] = count($sitelist);$sitelist_id["index"] = -1;foreach($sitelist AS $key=>$value){ $sitelist_id["num"]++;$sitelist_id["index"]++; ?>
			<option value="<?php echo $value['id'];?>"<?php if($value['id'] == $session['admin_site_id']){ ?> selected<?php } ?>><?php echo $value['alias'] ? $value['alias'] : $value['title'];?></option>
			<?php } ?>
		</select>
		<a href="javascript:add_site();void(0);" class="web_add" title="<?php echo P_Lang("添加新站点");?>"></a>		
		<?php } ?>
		<ul class="head_tab" id="phpok-taskbar"></ul>
	</div>
</div>

<div class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<?php if($iconlist){ ?>
	<td valign="top" width="180px">
	<div class="c_left">
		<ul>
			<?php $iconlist_id["num"] = 0;$iconlist=is_array($iconlist) ? $iconlist : array();$iconlist_id["total"] = count($iconlist);$iconlist_id["index"] = -1;foreach($iconlist AS $k=>$v){ $iconlist_id["num"]++;$iconlist_id["index"]++; ?>
			<li appfile="<?php echo $v['appfile'];?>"><a href="javascript:$.win('<?php echo P_Lang($v['title']);?>','<?php echo $v['url'];?>');void(0);"><span class="icon-<?php echo $v['icon'];?>"></span><?php echo P_Lang($v['title']);?></a></li>
			<?php } ?>
		</ul>
	</div>
	</td>
	<?php } ?>
	<td valign="top"><div class="index_main"<?php if(!$iconlist){ ?> style="margin-left:10px"<?php } ?>>
		<div class="sub_box" id="all_setting"<?php if(!$all_info){ ?> style="display:none;"<?php } ?>><?php echo $all_info;?></div>
		<div class="sub_box" id="list_setting"<?php if(!$list_setting){ ?> style="display:none;"<?php } ?>><?php echo $list_setting;?></div>
		<div class="clear"></div>
	</div></td>
</tr>

</table>
	<?php echo $GLOBALS["app"]->plugin_html_ap("body");?>
	<div class="clear"></div>
</div>
<?php echo $GLOBALS["app"]->plugin_html_ap("foot");?>
<div class="foot">
	<div class="foot_left">
		<?php if($app->license_powered){ ?>
		Powered by <a href="http://www.phpok.com" target="_blank">phpok.com</a>,
		<?php } ?>
		CopyRight &copy; <?php echo $license_site;?> <?php echo license_date();?>, All Right Reserved.
		<?php if($sys['debug']){ ?>
		<br /><?php echo debug_time('1','1','1','1');?>
		<?php } ?>
	</div>
	<div class="foot_right"><span class="darkblue"><?php echo $license;?></span><?php echo P_Lang("，版本：");?><?php echo $version;?></div>
</div>
<script type="text/javascript">
function pendding_info()
{
	var url = get_url('index','pendding');
	$.ajax({
		'url':url,
		'cache':false,
		'async':true,
		'dataType':'json',
		'success': function(rs){
			if(rs.status == "ok" && rs.content){
				var list = rs.content;
				var html = '<em class="toptip">{total}</em>';
				var total = 0;
				for(var key in list){
					if(list[key]['id'] == 'user' || list[key]['id'] == 'reply'){
						$("li[appfile="+list[key]['id']+"] a em").remove();
						$("li[appfile="+list[key]['id']+"] a").append(html.replace('{total}',list[key]['total']));
					}else{
						$("li[pid="+list[key]['id']+"] a em").remove();
						$("li[pid="+list[key]['id']+"] a").append(html.replace('{total}',list[key]['total']));
						total = parseInt(total) + parseInt(list[key]['total']);
					}
				}
				if(total>0){
					$("li[appfile=list] a em").remove();
					$("li[appfile=list] a").append(html.replace('{total}',total));
				}
				window.setTimeout("pendding_info()", 10000);
			}else{
				$("em.toptip").remove();
				window.setTimeout("pendding_info()", 12000);
			}
		}
	});
}
$(document).ready(function(){
	//关闭提示
	$.win2.init({'close_tip':'<?php echo $session['admin_rs']['close_tip'];?>'});
	pendding_info();
	//自定义右键
	var r_menu = [[{
		'text':'<?php echo P_Lang("刷新网页");?>',
		'func':function(){
			$.phpok.reload();
		}
	},{
		'text': "<?php echo P_Lang("清空缓存");?>",
		'func': function() {phpok_admin_clear();}    
	},{
		'text':'<?php echo P_Lang("修改我的信息");?>',
		'func':function(){phpok_admin_control();}
	},{
		'text': "<?php echo P_Lang("显示桌面");?>",
		'func': function() {$.desktop.tohome();}    
	}],[{
		'text':'<?php echo P_Lang("关于PHPOK");?>',
		'func':function(){
			$.dialog({
				'title':'<?php echo P_Lang("关于PHPOK");?>',
				'lock':true,
				'drag':false,
				'fixed':true,
				'content':'PHPOK企业站系统采用PHP+MySQL架构，基于LGPL协议开源并且免费。<br />本程序支持分类，项目，站点信息，模块等数据自定义<br />程序无任何内置广告代码<br />在使用过程序中，有任何问题，均可以登录 <a href="http://www.phpok.com/help.html" target="_blank" class="red">www.phpok.com/help.html</a> 查阅<br />如果您认可并打算捐助我们，点这里查看我们的收款账号：<a href="http://www.phpok.com/pay.html" target="_blank"style="color:red;">www.phpok.com/pay.html</a>'
			});
		}
	}]];
	$(window).smartMenu(r_menu,{'textLimit':8});
	$(document).keydown(function(e){
		if (e.keyCode == 8){
			return false;
		}
	});
});
</script>
<?php echo $app->plugin_html_ap("phpokbody");?></body>
</html>
