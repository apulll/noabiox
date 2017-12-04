<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $cate_rs ? $cate_rs['title'].' - '.$page_rs['title'] : $page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>
<div class="banner product-banner">
	<div class="nbox" <?php if($page_rs['banner']){ ?> style="background-image:url('<?php echo $page_rs['banner']['gd']['auto'];?>')"<?php } ?>></div>
</div>


<section>
    <div class="content">
      <div class="sec-nav">
        <?php $this->output("block_catelist_core_head","file"); ?>
        <!-- <ul>
          <li class="current"><a href="core-technology.html">核心菌种</a></li>
          <li><a href="core-technology.html">工艺制造技术</a></li>
          <li><a href="core-technology.html">应用技术</a></li>
        </ul> -->
      </div>

      <div class="section-content tech-section">
        <?php if($rslist){ ?>
        <div class="left">
          <div class="type-list">
            <ul >
              <?php $tmpid["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$tmpid["total"] = count($rslist);$tmpid["index"] = -1;foreach($rslist AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
              <?php if($value['thumb']){ ?>
              <li class="js-core-detail"><span href="javascript:void(0)" class="item" data-title=<?php echo $value['title'];?> data-id=<?php echo $value['id'];?> data-mid=<?php echo $value['module_id'];?> data-thumb=<?php echo $value['thumb']['gd']['auto'];?>><?php echo $value['title'];?></span></li>
              <?php } else { ?>
              <li class="js-core-detail"><span href="javascript:void(0)" class="item" data-title=<?php echo $value['title'];?> data-id=<?php echo $value['id'];?> data-mid=<?php echo $value['module_id'];?> ><?php echo $value['title'];?></span></li>
              <?php } ?>
              <?php } ?>
            </ul>
            
          </div>

        </div>
        <div class="section-main">
          <div class="main js-core-detail-wrapper">
      
            <?php $result = phpok_value_detail_core($rslist);?>
            <?php if($result){ ?>
            <h3><?php echo $result['title'];?></h3>
            <?php if($result['thumb']){ ?>
            <div class="img"><img src="<?php echo $result['thumb']['gd']['auto'];?>" alt="" /></div>
            <?php } else { ?>
            <div class="img"><img src="images/core_placeholder.jpg" alt="" /></div>
            <?php } ?>
            <p><span>来源：</span><?php echo $result['from'];?></p>
            <p><span>成果：</span><?php echo $result['rewards'];?></p>
            <p><span>功效：</span><?php echo $result['effect'];?></p>
            <?php } ?>
          </div>
        </div>
        
        <?php } ?>
      </div>
    </div>
  </section>
  
  <script src="tpl/www/js/core_tech.js"></script>
<?php $this->output("foot","file"); ?>