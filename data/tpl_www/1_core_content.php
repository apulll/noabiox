<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $rs['title'].' - '.$cate_rs['title'].' - '.$page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>
<div class="banner about-banner">
    <div class="nbox" <?php if($page_rs['banner']){ ?> style="background-image:url('<?php echo $page_rs['banner']['gd']['auto'];?>')"<?php } ?>></div>
  </div>
<section>
    <div class="content">
      <div class="crumbs"><a href="<?php echo $page_rs['url'];?>"><?php echo $page_rs['title'];?></a><i></i>
        <?php if($cate_rs){ ?>
        <a href="<?php echo $cate_rs['url'];?>"><?php echo $cate_rs['title'];?></a>
        <i></i>
        <?php } ?>
        <span><?php echo $rs['title'];?></span></div>
      <div class="product-parameter">
        <div class="l-img"><img src="img/pro-n1.png" alt=""><span class="v-am"></span></div>
        <div class="r-desc">
          <h3><?php echo $rs['title'];?></h3>
          <ul>
            <?php $tmpid["num"] = 0;$rs['attrs']=is_array($rs['attrs']) ? $rs['attrs'] : array();$tmpid["total"] = count($rs['attrs']);$tmpid["index"] = -1;foreach($rs['attrs'] AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
            <li><span><?php echo $key;?>：</span> <?php echo $value;?></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="product-content">
        <?php echo $rs['content'];?>
      </div>
    </div>
  </section>
<?php $this->output("foot","file"); ?>