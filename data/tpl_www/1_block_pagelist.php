<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $pagelist = phpok_page($pageurl,$total,$pageid,$psize,"prev=<<&next=>>");?>
<div class="pages">
	<?php $pagelist_id["num"] = 0;$pagelist=is_array($pagelist) ? $pagelist : array();$pagelist_id["total"] = count($pagelist);$pagelist_id["index"] = -1;foreach($pagelist AS $key=>$value){ $pagelist_id["num"]++;$pagelist_id["index"]++; ?>
		<?php if($value['nolink']){ ?>
		<span><?php echo $value['title'];?></span>
		<?php } else { ?>
		<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>" <?php if($value['status']){ ?> class="current"<?php } ?>><?php echo $value['title'];?></a>
		<?php } ?>
	<?php } ?>
</div>