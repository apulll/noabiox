<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><div class="title">
	分类：
	<span class="note">请绑定分类，默认绑定根分类信息</span>
</div>
<div class="content">
	<select id="cateid" name="cateid">
	<option value="<?php echo $cate_rs['id'];?>"<?php if($val && in_array($cate_rs['id'],$val)){ ?> selected<?php } ?>><?php echo $cate_rs['title'];?></option>
	<?php $catelist_id["num"] = 0;$catelist=is_array($catelist) ? $catelist : array();$catelist_id["total"] = count($catelist);$catelist_id["index"] = -1;foreach($catelist AS $key=>$value){ $catelist_id["num"]++;$catelist_id["index"]++; ?>
	<option value="<?php echo $value['id'];?>"<?php if($val && in_array($value['id'],$val)){ ?> selected<?php } ?>>&nbsp; &nbsp; <?php echo $value['_space'];?><?php echo $value['title'];?></option>
	<?php } ?>
	</select>
</div>
