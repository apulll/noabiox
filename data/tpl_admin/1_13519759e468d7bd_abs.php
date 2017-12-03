<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><input type="hidden" name="ext_form_id" id="ext_form_id" value="p_name,p_type,p_width" />
<div class="table">
	<div class="title">
		参数列表：
		<span class="note">一行一个参数名称</span>
	</div>
	<div class="content">
		<textarea name="p_name" id="p_name" class="long" style="height:80px;"><?php echo $rs['p_name'];?></textarea>
	</div>
</div>
<div class="table">
	<div class="title">
		属性：
		<span class="note">“<span class="red">内容</span>”即一个参数名称对应一个内容，“<span class="red">列表</span>”即支持多个内容信息，允许普通用户创建</span>
	</div>
	<div class="content">
		<table cellpadding="0" cellspacing="0">
		<tr>
			<td><label><input type="radio" name="p_type" id="p_type" value="0"<?php if(!$rs['p_type']){ ?> checked<?php } ?> />内容</label></td>
			<td><label><input type="radio" name="p_type" id="p_type" value="1"<?php if($rs['p_type']){ ?> checked<?php } ?> />列表</label></td>
		</tr>
		</table>
	</div>
</div>
<div class="table">
	<div class="title">
		文本框宽度：
		<span class="note">不设置时，内容项将以300作为宽度，列表项将以80作为宽度，只要填写数字</span>
	</div>
	<div class="content">
		<input type="text" id="p_width" name="p_width" class="default" value="<?php echo $rs['p_width'];?>" />
	</div>
</div>