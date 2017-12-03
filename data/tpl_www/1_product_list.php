<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $cate_rs ? $cate_rs['title'].' - '.$page_rs['title'] : $page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>
<div class="banner product-banner">
	<div class="nbox" <?php if($page_rs['banner']){ ?> style="background-image:url('<?php echo $page_rs['banner']['gd']['auto'];?>')"<?php } ?>></div>
</div>


<section>
    <div class="content">
      <div class="title">
        <h3>产品中心</h3>
        <div class="fr">
          <div class="search-box js-search-box">
            <input type="text" class="js-search-input">
            <span class="js-search-sub"></span>
          </div>
        </div>
      </div>
      <div class="section-content product-section">
        <div class="left">
          <div class="cate-list">
            <?php $this->output("block_catelist_product","file"); ?>
          </div>
        </div>
        <div class="section-main">
          <div class="tit"><?php echo $cate_rs['title'];?></div>
          <div class="products-list">
            <?php if($rslist){ ?>
            <ul>
              
              <?php $tmpid["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$tmpid["total"] = count($rslist);$tmpid["index"] = -1;foreach($rslist AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>

              
              <?php if($value['thumb']){ ?>
              <?php $thumb = current($value['thumb']);?>
              <li><a href="<?php echo $value['url'];?>" class="p-box"><span class="img"><img src="<?php echo $thumb['gd']['thumb'];?>" alt=""><span class="v-am"></span></span><h3><?php echo $value['title'];?></h3><p><?php echo $value['note'] ? phpok_cut($value['note'],15,'…') : phpok_cut($value['content'],15,'…');?></p></a></li>
              <?php } else { ?>
              <li><a href="<?php echo $value['url'];?>" class="p-box"><span class="img"><img src="" alt=""><span class="v-am"></span></span><h3><?php echo $value['title'];?></h3><p><?php echo $value['note'] ? phpok_cut($value['note'],15,'…') : phpok_cut($value['content'],15,'…');?></p></a></li>
              <?php } ?>
              
			       <?php } ?>
            </ul>
            <?php } else { ?>
              暂无内容
            <?php } ?>
          </div>
        </div>
      </div>
      <?php $this->output("block_pagelist","file"); ?>

    </div>
</section>
<script src="tpl/www/js/product.js"></script>
<?php $this->output("foot","file"); ?>