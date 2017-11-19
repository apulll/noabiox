<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head","file"); ?>
<script type="text/javascript" src="<?php echo add_js('call.js');?>"></script>
<div class="tips">
	您当前的位置：<a href="<?php echo admin_url('call');?>" title="调用列表">调用列表</a>
	&raquo; <?php if($id){ ?>编辑<?php } else { ?>添加新<?php } ?>调用
</div>
<form method="post" action="<?php echo admin_url('call','save');?>" onsubmit="return check_save()">
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<div class="table">
	<div class="title">
		项目ID：
		<span class="note">此参数可在调用时替换</span>
	</div>
	<div class="content">
		<select id="pid" name="pid" onchange="update_param(this.value)">
		<option value="">默认，使用GET或POST里的ID</option>
		<?php $rslist_id["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$rslist_id["total"] = count($rslist);$rslist_id["index"] = -1;foreach($rslist AS $key=>$value){ $rslist_id["num"]++;$rslist_id["index"]++; ?>
		<option value="<?php echo $value['id'];?>"<?php if($rs['pid'] == $value['id']){ ?> selected<?php } ?>><?php echo $value['space'];?><?php echo $value['title'];?></option>
		<?php } ?>
		</select>
	</div>
</div>
<div class="table">
	<div class="title">
		标题：
		<span class="note">填写该调用的基本说明，不超过80汉字，此项用于后台管理</span>
	</div>
	<div class="content">
		<input type="text" id="title" name="title" class="long" value="<?php echo $rs['title'];?>" />
	</div>
</div>
<?php if($id){ ?>
<div class="table">
	<div class="title">
		标识串：
		<span class="red i b"><?php echo $rs['identifier'];?></span>
	</div>
</div>
<?php } else { ?>
<div class="table">
	<div class="title">标识串：<span class="note">此标识串将在模板中被调用，支持小写字母、数字及下划线且必须是小写字母开头</span></div>
	<div class="content">
		<input type="text" id="identifier" name="identifier" class="default" value="<?php echo $rs['identifier'];?>" />
		<span id="identifier_ext_btn"></span>
	</div>
</div>
<?php } ?>
<div id="cate_list" class="table hide"></div>
<div class="table">
	<div class="title">
		调用类型：
	</div>
	<div class="content" id="content_type_id">
		<select id="type_id" name="type_id" onchange="update_type_id(this.value)">
		<option value="">请选择……</option>
		<?php $phpok_type_list_id["num"] = 0;$phpok_type_list=is_array($phpok_type_list) ? $phpok_type_list : array();$phpok_type_list_id["total"] = count($phpok_type_list);$phpok_type_list_id["index"] = -1;foreach($phpok_type_list AS $key=>$value){ $phpok_type_list_id["num"]++;$phpok_type_list_id["index"]++; ?>
		<option value="<?php echo $key;?>"<?php if($rs['type_id'] == $key){ ?> selected<?php } ?>><?php echo $value;?></option>
		<?php } ?>
		</select>
	</div>
</div>

<div id="arclist_info" class="hide">
	<div class="table" id="html_psize">
		<div class="title">
			调用数量：
			<span class="note">设置调用的最大值，设为0表示不限制数量</span>
		</div>
		<div class="content">
			<input type="text" id="psize" name="psize" class="short" value="<?php echo $rs['psize'];?>" />
		</div>
	</div>
	<div class="table">
		<div class="title">
			开始位置：
			<span class="note">不设置将使用0开始调用（即第一条开始）</span>
		</div>
		<div class="content">
			<input type="text" id="offset" name="offset" class="short" value="<?php echo $rs['offset'] ? $rs['offset'] : 0;?>" />
		</div>
	</div>
	<div class="table">
		<div class="title">
			列表模式：
			<span class="note">启用列表您需要循环将数据显示（推荐使用），反之则只显示一条数据</span>
		</div>
		<div class="content">
			<table>
			<tr>
				<td><label><input type="radio" name="is_list" value="0"<?php if($id && !$rs['is_list']){ ?> checked<?php } ?> /> 只读一条<span class="gray i">（使用此项请将数量设置为1）</span></label></td>
				<td><label><input type="radio" name="is_list" value="1"<?php if($rs['is_list'] || !$id){ ?> checked<?php } ?> /> 列表模式</label></td>
			</tr>
			</table>
		</div>
	</div>
	<div class="table">
		<div class="title">
			子主题：
			<span class="note">是否同时读取子主题信息</span>
		</div>
		<div class="content">
			<table>
			<tr>
				<td><label><input type="radio" name="in_sub" value="0"<?php if(!$rs['in_sub']){ ?> checked<?php } ?> /> 禁用</label></td>
				<td><label><input type="radio" name="in_sub" value="1"<?php if($rs['in_sub']){ ?> checked<?php } ?> /> 启用</label></td>
			</tr>
			</table>
		</div>
	</div>
	<div class="table">
		<div class="title">
			主题属性：
			<span class="note">设置要调用的主题属性，仅支持单选，请慎用</span>
		</div>
		<div class="content">
			<table><tr>
				<td><label><input type="radio" name="attr" value=""<?php if(!$id || !$rs['attr']){ ?> checked<?php } ?> />不限</label></td>
				<?php $attr = $rs['attr'] ? explode(",",$rs['attr']) : array();?>
				<?php $attrlist_id["num"] = 0;$attrlist=is_array($attrlist) ? $attrlist : array();$attrlist_id["total"] = count($attrlist);$attrlist_id["index"] = -1;foreach($attrlist AS $key=>$value){ $attrlist_id["num"]++;$attrlist_id["index"]++; ?>
				<td><label><input type="radio" name="attr" value="<?php echo $key;?>"<?php if($rs['attr'] == $key){ ?> checked<?php } ?> /><?php echo $value;?></label></td>
					<?php if($attrlist_id['num'] % 8 ==''){ ?></tr><tr><?php } ?>
				<?php } ?>
			</tr></table>
		</div>
	</div>
	<div class="table">
		<div class="title">
			字段值必须存在：
			<span class="note">设置哪些字段值必须存在，不存在的值将不被调用</span>
		</div>
		<div class="content">
			<input type="text" id="fields_need" name="fields_need" class="long" value="<?php echo $rs['fields_need'];?>" />
			<input type="button" value="清空" class="btn" onclick="$('#fields_need').val('')" />
			<ul class="btnlist" id="fields_need_list"></ul>
		</div>
	</div>
	<div class="table">
		<div class="title">
			Tag标签：
			<span class="note">设置要调用的标签，多个Tag用英文逗号隔开</span>
		</div>
		<div class="content">
			<input type="text" id="tag" name="tag" class="long" value="<?php echo $rs['tag'];?>" />
		</div>
	</div>
	<div class="table">
		<div class="title">
			关键字：
			<span class="note">多个关键字用英文逗号隔开，适用于获取相关内容</span>
		</div>
		<div class="content">
			<input type="text" id="keywords" name="keywords" class="long" value="<?php echo $rs['keywords'];?>" />
		</div>
	</div>
	<div class="table">
		<div class="title">
			数据排序：
			<span class="note">设置数据常用的排序方法</span>
		</div>
		<div class="content">
			<input type="text" id="orderby" name="orderby" class="long" value="<?php echo $rs['orderby'];?>" />
			<input type="button" value="清空" class="btn" onclick="$('#orderby').val('')" />
			
			<ul class="btnlist" id="orderby_li"></ul>
		</div>
	</div>
</div>
<div class="hide" id="cate_info">
	<div class="table">
		<div class="title">
			分类标识：
			<span class="note">填写分类标识串，使用此项将替代上面的分类ID</span>
		</div>
		<div class="content">
			<input type="text" id="cate" name="cate" class="default" value="<?php echo $rs['cate'];?>" />
			<input type="button" value="清空" onclick="$('#cate').val('')" class="button" />
		</div>
	</div>
</div>

<div class="hide" id="fields_info">
	<div class="table">
		<div class="title">
			格式化：
			<span class="note">是否将字段格式化为HTML信息，用于表单</span>
		</div>
		<div class="content">
			<table>
			<tr>
				<td><label><input type="radio" name="fields_format" value="0"<?php if(!$rs['fields_format']){ ?> checked<?php } ?> /> 禁用</label></td>
				<td><label><input type="radio" name="fields_format" value="1"<?php if($rs['fields_format']){ ?> checked<?php } ?> /> 启用</label></td>
			</tr>
			</table>
		</div>
	</div>
</div>

<div class="hide" id="user_info">
	<div class="table">
		<div class="title">
			自定义信息：
			<span class="note">读取数据是否同时读取相应的自定义内容数据</span>
		</div>
		<div class="content">
			<table>
			<tr>
				<td><label><input type="radio" name="user_ext" value="0"<?php if(!$rs['user_ext']){ ?> checked<?php } ?> /> 禁用</label></td>
				<td><label><input type="radio" name="user_ext" value="1"<?php if($rs['user_ext']){ ?> checked<?php } ?> /> 启用</label></td>
			</tr>
			</table>
		</div>
	</div>
	<div class="table">
		<div class="title">
			会员账号：
			<span class="note">多个账号用英文逗号隔开</span>
		</div>
		<div class="content">
			<input type="text" id="user" name="user" class="default" value="<?php echo $rs['user'];?>" />
			<input type="button" value="清空" onclick="$('#user').val('')" class="button" />
		</div>
	</div>
</div>

<div class="hide" id="userlist_info">
	<div class="table">
		<div class="title">
			自定义信息：
			<span class="note">读取数据是否同时读取相应的自定义内容数据</span>
		</div>
		<div class="content">
			<table>
			<tr>
				<td><label><input type="radio" name="userlist_ext" value="0"<?php if(!$rs['userlist_ext']){ ?> checked<?php } ?> /> 禁用</label></td>
				<td><label><input type="radio" name="userlist_ext" value="1"<?php if($rs['userlist_ext']){ ?> checked<?php } ?> /> 启用</label></td>
			</tr>
			</table>
		</div>
	</div>
</div>


<div class="hide" id="orderby_default">
	<li><input type="button" value="点击" onclick="phpok_admin_orderby('orderby','l.hits')" /></li>
	<li><input type="button" value="时间" onclick="phpok_admin_orderby('orderby','l.dateline')" /></li>
	<li><input type="button" value="回复时间" onclick="phpok_admin_orderby('orderby','l.replydate')" /></li>
	<li><input type="button" value="ID" onclick="phpok_admin_orderby('orderby','l.id')" /></li>
	<li><input type="button" value="人工" onclick="phpok_admin_orderby('orderby','l.sort')" /></li>
	<li><input type="button" value="随机，慎用" onclick="$('#orderby').val('RAND()')" /></li>
</div>
<div class="hide" id="fields_need_default">
	<li><input type="button" value="会员" onclick="fields_click('l.user_id')" /></li>
</div>

<div id="arc_info" class="hide" alt="文章内容，可以手动指定一个ID或是标识">
	<div class="table">
		<div class="title">
			主题标识或ID：
			<span class="note">当填写为纯数字，表示ID</span>
		</div>
		<div class="content">
			<input type="text" id="title_id" name="title_id" class="default" value="<?php echo $rs['title_id'];?>" />
			<input type="button" value="清空" onclick="$('#title_id').val('')" class="button" />
		</div>
	</div>
</div>

<div class="table">
	<div class="title">
		状态：
		<span class="note">未审核下不能被前台调用</span>
	</div>
	<div class="content">
		<table>
			<tr>
				<td><label for="status_0"><input type="radio" name="status" id="status_0" value="0"<?php if($id && !$rs['status']){ ?> checked<?php } ?> />未审核</label></td>
				<td><label for="status_1"><input type="radio" name="status" id="status_1" value="1"<?php if(!$id || $rs['status']){ ?> checked<?php } ?> />已审核</label></td>
			</tr>
			</table>
	</div>
</div>
<br />
<div class="table">
	<div class="content">
		<input type="submit" value="提 交" class="submit" />
	</div>
</div>
<br />
<script type="text/javascript">
$(document).ready(function(){
	var param = "<?php echo $rs['pid'];?>";
	var cate_id = "<?php echo $rs['cateid'];?>";
	update_param(param,cate_id);
});
</script>
<?php $this->output("foot","file"); ?>