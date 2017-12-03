<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head","file"); ?>
<script type="text/javascript" src="<?php echo add_js('module.js');?>"></script>
<script type="text/javascript">
function update_taxis(val,id)
{
	$.ajax({
		'url':get_url('module','taxis','taxis='+val+"&id="+id),
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
	<div class="action"><a href="<?php echo phpok_url(array('ctrl'=>'module','func'=>'set'));?>">添加模块</a></div>
	<div class="action"><a href="javascript:module_import();void(0);">模块导入</a></div>
	您当前的位置：
	<a href="<?php echo phpok_url(array('ctrl'=>'module'));?>">模块管理</a>
	&raquo; 模块列表<?php if($rslist){ ?><span class="red">(<?php echo count($rslist);?>)</span><?php } ?>
</div>
<div class="list">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<th width="50px">ID</th>
	<th width="30px">&nbsp;</th>
	<th class="lft">名称</th>
	<th>排序</th>
	<th width="376">操作</th>
</tr>
<?php $rslist_id["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$rslist_id["total"] = count($rslist);$rslist_id["index"] = -1;foreach($rslist AS $key=>$value){ $rslist_id["num"]++;$rslist_id["index"]++; ?>
<tr>
	<td align="center"><?php echo $value['id'];?></td>
	<td><span class="status<?php echo $value['status'];?>" id="status_<?php echo $value['id'];?>" onclick="set_status(<?php echo $value['id'];?>)" value="<?php echo $value['status'];?>"></span></td>
	<td><label for="tid_<?php echo $value['id'];?>"><?php echo $value['title'];?><?php if($value['note']){ ?><span class="gray i">（<?php echo $value['note'];?>）</span><?php } ?></label></td>
	<td class="center"><div class="gray i hand center" title="<?php echo P_Lang("点击调整排序");?>" name="taxis" data="<?php echo $value['id'];?>"><?php echo $value['taxis'];?></div></td>
	<td>
		<div class="button-group">
			<input type="button" value="<?php echo P_Lang("编辑");?>" onclick="$.phpok.go('<?php echo phpok_url(array('ctrl'=>'module','func'=>'set','id'=>$value['id']));?>')" class="phpok-btn" />
			<input type="button" value="<?php echo P_Lang("删除");?>" onclick="module_del('<?php echo $value['id'];?>','<?php echo $value['title'];?>')" class="phpok-btn" />
			<input type="button" value="<?php echo P_Lang("字段管理");?>" onclick="$.phpok.go('<?php echo phpok_url(array('ctrl'=>'module','func'=>'fields','id'=>$value['id']));?>')" class="phpok-btn" />
			<input type="button" value="<?php echo P_Lang("复制模块");?>" onclick="module_copy('<?php echo $value['id'];?>','<?php echo $value['title'];?>')" class="phpok-btn" />
			<input type="button" value="<?php echo P_Lang("字段显示");?>" onclick="module_layout('<?php echo $value['id'];?>','<?php echo $value['title'];?>')" class="phpok-btn" />
			<input type="button" value="<?php echo P_Lang("导出");?>" onclick="module_export('<?php echo $value['id'];?>')" class="phpok-btn" />
		</div>
	</td>
</tr>
<?php } ?>
</table>
</div>
<?php $this->output("foot","file"); ?>
