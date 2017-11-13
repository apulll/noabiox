<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><input type="hidden" name="ext_form_id" id="ext_form_id" value="form_btn,width,ext_quick_words,ext_quick_type" />
<div class="table">
	<div class="title">
		扩展按钮：
		<span class="note">设置文本框后跟随的按钮</span>
	</div>
	<div class="content">
		<table>
		<tr>
			<td>
				<select name="form_btn" id="form_btn">
					<option value="">默认</option>
					<option value="date"<?php if($rs['form_btn'] == "date"){ ?> selected<?php } ?>>日期选择器</option>
					<option value="datetime"<?php if($rs['form_btn'] == "datetime"){ ?> selected<?php } ?>>日期时间选择器</option>
					<option value="file"<?php if($rs['form_btn'] == "file"){ ?> selected<?php } ?>>附件选择</option>
					<option value="image"<?php if($rs['form_btn'] == "image"){ ?> selected<?php } ?>>图片库</option>
					<option value="video"<?php if($rs['form_btn'] == "video"){ ?> selected<?php } ?>>影音列表</option>
					<option value="url"<?php if($rs['form_btn'] == "url"){ ?> selected<?php } ?>>网址</option>
					<option value="user"<?php if($rs['form_btn'] == "user"){ ?> selected<?php } ?>>会员</option>
					<option value="color"<?php if($rs['form_btn'] == "color"){ ?> selected<?php } ?>>颜色选择器</option>
				</select>
			</td>
		</tr>
		</table>
	</div>
</div>
<div class="table">
	<div class="title">
		表单宽度：
		<span class="note">设置表单的宽度，这是只需要<span class="red">填写数字</span></span>
	</div>
	<div class="content">
		<input type="text" name="width" id="width" value="<?php echo $rs['width'];?>" /> px
	</div>
</div>
<div class="table">
	<div class="title">
		快捷内容：
		<span class="note">一行一个值，使用此项可以通过点击来实现快速输入</span>
	</div>
	<div class="content">
		<textarea name="ext_quick_words" style="width:99%;height:180px;"><?php echo $rs['ext_quick_words'];?></textarea>
	</div>
</div>
<div class="table">
	<div class="title">
		快捷内容输入分割单词：
		<span class="note">点击多个快捷输入，使用哪类单词分割，覆盖请设置：<span class="red" style="cursor:pointer;" onclick="$('#ext_quick_type').val('none')">none</span>，建议使用逗号<span class="red" style="cursor:pointer;" onclick="$('#ext_quick_type').val(',')">（,）</span>或是斜线<span class="red" style="cursor:pointer;" onclick="$('#ext_quick_type').val('/')">（/）</span></span>
	</div>
	<div class="content">
		<input type="text" name="ext_quick_type" id="ext_quick_type" value="<?php echo $rs['ext_quick_type'];?>" />
	</div>
</div>
