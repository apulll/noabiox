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
          <div class="search-box">
            <input type="text">
            <span></span>
          </div>
        </div>
      </div>
      <div class="section-content product-section">
        <div class="left">
          <div class="cate-list">
            <ul>
              <li><div class="m current"><span class="t">菌粉原料产品</span><i class="arrow"></i></div>
                <ul style="display:block">
                  <li class="current"><a href="product.html">功能性菌粉</a></li>
                  <li><a href="product2.html">乳制品直投式发酵剂</a></li>
                  <li><a href="product3.html">果蔬直投式发酵剂</a></li>
                  <li><a href="product4.html">动物用菌粉</a></li>
                </ul>
              </li>
              <li><div class="m"><span class="t">发酵原料产品</span><i class="arrow"></i></div>
                <ul>
                  <li><a href="">功能性菌粉</a></li>
                  <li><a href="">乳制品直投式发酵剂</a></li>
                  <li><a href="">果蔬直投式发酵剂</a></li>
                  <li><a href="">动物用菌粉</a></li>
                </ul>
              </li>
              <li><div class="m"><span class="t">产品应用</span><i class="arrow"></i></div>
                <ul>
                  <li><a href="">功能性菌粉</a></li>
                  <li><a href="">乳制品直投式发酵剂</a></li>
                  <li><a href="">果蔬直投式发酵剂</a></li>
                  <li><a href="">动物用菌粉</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div class="section-main">
          <div class="tit"><?php echo $cate_rs['title'];?></div>
          <div class="products-list">
            <ul>
              <?php $tmpid["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$tmpid["total"] = count($rslist);$tmpid["index"] = -1;foreach($rslist AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
              <?php $thumb = current($value['thumb']);?>
              <li><a href="<?php echo $value['url'];?>" class="p-box"><span class="img"><img src="<?php echo $thumb['gd']['thumb'];?>" alt=""><span class="v-am"></span></span><h3><?php echo $value['title'];?></h3><p><?php echo $value['note'];?></p></a></li>
			 <?php } ?>
            </ul>
            
          </div>
        </div>
      </div>
      <?php $this->output("block_pagelist","file"); ?>

    </div>
</section>

<?php $this->output("foot","file"); ?>