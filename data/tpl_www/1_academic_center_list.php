<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $cate_rs ? $cate_rs['title'].' - '.$page_rs['title'] : $page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>
<div class="banner about-banner">
	<div class="nbox" <?php if($page_rs['banner']){ ?> style="background-image:url('<?php echo $page_rs['banner']['gd']['auto'];?>')"<?php } ?>></div>
</div>
<section>
<div class="content">
  <?php $this->output("block_catelist_new","file"); ?>
  <div class="article-list">
    <ul>

      <?php $rslist_id["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$rslist_id["total"] = count($rslist);$rslist_id["index"] = -1;foreach($rslist AS $key=>$value){ $rslist_id["num"]++;$rslist_id["index"]++; ?>
		<li>
			<div class="article-box">
			<?php if($value['thumb']){ ?>
			<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><img src="<?php echo $value['thumb']['gd']['auto'];?>" alt="<?php echo $value['title'];?>" /></a>
			<?php } ?>
			<h3><a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><?php echo $value['title'] ? phpok_cut($value['title'],20,'…') : phpok_cut($value['title'],20,'…');?><span class="fr"><?php echo $value['dateline'];?></span></a></h3>
			<p class="desc"><?php echo $value['note'] ? phpok_cut($value['note'],225,'…') : phpok_cut($value['content'],225,'…');?></p>
			<div class="more"><a href="<?php echo $value['url'];?>" title="查看<?php echo $value['title'];?>详细信息">了解详情 <i></i></a></div>
			</div>
		</li>
		<?php } ?>
    </ul>
      
  </div>
  <?php $this->output("block_pagelist","file"); ?>
</div>
</section>



<?php $this->output("foot","file"); ?>