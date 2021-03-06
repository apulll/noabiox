<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head","file"); ?>
<script type="text/javascript" src="<?php echo add_js('module.js');?>"></script>
<script type="text/javascript">
function update_taxis(val,id)
{
	$.ajax({
		'url':get_url('module','field_taxis','taxis='+val+"&id="+id),
		'dataType':'json',
		'cache':false,
		'async':true,
		'beforeSend': function (XMLHttpRequest){
			XMLHttpRequest.setRequestHeader("request_type","ajax");
		},
		'success':function(rs){
			if(rs.status == 'ok'){
				$.phpok.reload();
			}else{
				$.dialog.alert(rs.content);
				return false;
			}
		}
	});
}
$(document).ready(function(){
	$("div[name=taxis]").click(function(){
		var oldval = $(this).text();
		var id = $(this).attr('data');
		$.dialog.prompt('<?php echo P_Lang("请填写新的排序：");?>',function(val){
			if(val != oldval){
				update_taxis(val,id);
			}
		},oldval);
	});
});
</script>

<div class="tips">
	<div class="action"><a href="javascript:module_field_create('<?php echo $id;?>');void(0);" title="添加字段">添加字段</a></div>
	您当前的位置：
	<a href="<?php echo phpok_url(array('ctrl'=>'module'));?>">模块管理</a>
	&raquo; <span class="red"><?php echo $rs['title'];?></span>字段管理器
</div>

<?php if($used_list){ ?>
<div class="list">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<th class="lft">&nbsp;字段名</th>
	<th class="lft">名称</th>
	<th class="lft">备注</th>
	<th class="lft">排序</th>
	<th></th>
</tr>
<?php $used_list_id["num"] = 0;$used_list=is_array($used_list) ? $used_list : array();$used_list_id["total"] = count($used_list);$used_list_id["index"] = -1;foreach($used_list AS $key=>$value){ $used_list_id["num"]++;$used_list_id["index"]++; ?>
<tr>
	<td><?php echo $value['identifier'];?></td>
	<td><?php echo $value['title'];?></td>
	<td><?php echo $value['note'];?></td>
	<td><div class="gray i hand center" title="<?php echo P_Lang("点击调整排序");?>" name="taxis" data="<?php echo $value['id'];?>"><?php echo $value['taxis'];?></div></td>
	<td>
		<div class="button-group">
			<input type="button" value="<?php echo P_Lang("编辑");?>" onclick="module_field_edit('<?php echo $value['id'];?>')" class="phpok-btn" />
			<input type="button" value="<?php echo P_Lang("删除");?>" onclick="module_field_del('<?php echo $value['id'];?>','<?php echo $value['title'];?>')" class="phpok-btn" />
		</div>
	</td>
</tr>
<?php } ?>
</table>
</div>
<?php } ?>
<?php if($fields_list){ ?>
<div class="tips">
	<div class="action"><a href="javascript:top.$.win('字段维护','<?php echo phpok_url(array('ctrl'=>'fields','func'=>'set'));?>')" title="创建常用字段">创建常用字段</a></div>
	常见字段快速添加</div>
<div class="list2">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<th class="id">ID</th>
	<th class="lft" style="width:130px">&nbsp;字段名</th>
	<th class="lft" style="width:150px">&nbsp;名称</th>
	<th class="lft">&nbsp;备注</th>
	<th class="lft w30">添加</th>
</tr>
<?php $fields_list_id["num"] = 0;$fields_list=is_array($fields_list) ? $fields_list : array();$fields_list_id["total"] = count($fields_list);$fields_list_id["index"] = -1;foreach($fields_list AS $key=>$value){ $fields_list_id["num"]++;$fields_list_id["index"]++; ?>
<tr<?php if($fields_list_id['num']%2 == ""){ ?> class="list"<?php } ?> title="<?php echo $value['note'];?>">
	<td class="center"><?php echo $value['id'];?></td>
	<td><label for="field_<?php echo $value['id'];?>"><?php echo $value['identifier'];?></label></td>
	<td><input type="text" id="field_title_<?php echo $value['id'];?>" name="field_title_<?php echo $value['id'];?>" value="<?php echo $value['title'];?>" style="width:150px" /></td>
	<td><input type="text" id="field_note_<?php echo $value['id'];?>" name="field_note_<?php echo $value['id'];?>" value="<?php echo $value['note'];?>" style="width:430px" /></td>
	<td><a class="icon add" onclick="module_field_add('<?php echo $id;?>','<?php echo $value['id'];?>')" title="添加：<?php echo $value['identifier'];?>"></a></td>
</tr>
<?php } ?>
</table>
</div>
<?php } ?>

<?php $this->output("foot","file"); ?>