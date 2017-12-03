<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head_open","file"); ?>
<form method="post" id="module_add" action="<?php echo admin_url('module','layout_save');?>">
<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
<div class="table">
	<div class="title">
		<?php echo P_Lang("后台字段布局：");?>
		<span class="note"><?php echo P_Lang("在这里设置要显示的字段属性");?></span>
	</div>
	<div class="content">
		<ul class="layout">
			<li><label><input type="checkbox" name="layout[]" value="hits"<?php if(in_array("hits",$layout)){ ?> checked<?php } ?> /><?php echo P_Lang("查看次数");?></label></li>
			<li><label><input type="checkbox" name="layout[]" value="dateline"<?php if(in_array("dateline",$layout)){ ?> checked<?php } ?> /><?php echo P_Lang("发布时间");?></label></li>
			<?php $used_list_id["num"] = 0;$used_list=is_array($used_list) ? $used_list : array();$used_list_id["total"] = count($used_list);$used_list_id["index"] = -1;foreach($used_list AS $key=>$value){ $used_list_id["num"]++;$used_list_id["index"]++; ?>
			<li><label><input type="checkbox" name="layout[]" id="layout_<?php echo $value['identifier'];?>" value="<?php echo $value['identifier'];?>"<?php if(in_array($value['identifier'],$layout)){ ?> checked<?php } ?> /><?php echo $value['title'];?></label></li>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="table">
	<div class="content">
		<br />
		<input type="submit" value="提 交" class="submit" />
		<br />
	</div>
</div>
</form>

<?php $this->output("foot_open","file"); ?>