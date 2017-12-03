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
      <?php $tmpid["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$tmpid["total"] = count($rslist);$tmpid["index"] = -1;foreach($rslist AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<li>
			<div class="article-box">
			
			<a href="<?php echo $value['url'];?>">
				<?php if($value['thumb']){ ?>
				<img src="<?php echo $value['thumb']['gd']['auto'];?>" alt="<?php echo $value['title'];?>" width="490" height="310" />
				<?php } else { ?>
				<img src="images/news_placeholder.jpg" alt="<?php echo $value['title'];?>" width="490" height="310" />
				<?php } ?>
			</a>
			
			<?php $dateline = phpok_date($value['dateline']);?>
			<h3><a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><?php echo $value['title'] ? phpok_cut($value['title'],20,'…') : phpok_cut($value['title'],20,'…');?><span class="fr"><?php echo $dateline;?></span></a></h3>
			<p class="desc"><?php echo $value['note'] ? phpok_cut($value['note'],60,'…') : phpok_cut($value['content'],60,'…');?></p>
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