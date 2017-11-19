<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $menutitle="网站首页";?><?php $this->assign("menutitle","网站首页"); ?><?php $this->output("head","file"); ?>
<link rel="stylesheet" type="text/css" href="tpl/www/css/index.css">
<script src="tpl/www/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="tpl/www/js/index.js"></script>

<?php $list = phpok('picplayer');?>
<?php if($list['total']){ ?>
<div class="banner index-banner">
	<div id="banner">
	 <?php $list_rslist_id["num"] = 0;$list['rslist']=is_array($list['rslist']) ? $list['rslist'] : array();$list_rslist_id["total"] = count($list['rslist']);$list_rslist_id["index"] = -1;foreach($list['rslist'] AS $key=>$value){ $list_rslist_id["num"]++;$list_rslist_id["index"]++; ?>
	 	<div class="nbox b-1" style="background-image:url(<?php echo $value['banner']['filename'];?>)"></div>
	 <?php } ?>
	</div>
</div>
<?php } ?>



<section>
    <div class="about-section">
      <?php $arc = phpok('gywm');?>
      <div class="content about-content">
        <h3 class="tit"><?php echo $arc['project']['title'];?></h3>
        <div class="desc"><?php echo $arc['project']['alias_note'];?></div>
        <div class="list">
          <ul>
          	<?php $arc_rslist_id["num"] = 0;$arc['rslist']=is_array($arc['rslist']) ? $arc['rslist'] : array();$arc_rslist_id["total"] = count($arc['rslist']);$arc_rslist_id["index"] = -1;foreach($arc['rslist'] AS $key=>$value){ $arc_rslist_id["num"]++;$arc_rslist_id["index"]++; ?>
          	<?php $info = get_aa_bb($value);?>
            <li><a href="<?php echo $value['url'];?>"><i class="icon-about icon-<?php echo $value['sort'];?>"></i><p><?php echo $value['title'];?></p></a></li>
            <!-- <li><a href="mission.html"><i class="icon-about icon-2"></i><p>使命与责任</p></a></li>
            <li><a href="core.html"><i class="icon-about icon-3"></i><p>核心与优势</p></a></li>
            <li><a href="honor.html"><i class="icon-about icon-4"></i><p>资质荣誉</p></a></li> -->

            <?php } ?>
          </ul>
        </div>
        <div class="about-img"><img src="tpl/www/images/about-img.png" alt=""></div>
      </div>
    </div>
    <div class="develop-section">
     <?php $yfz = phpok('yfzxfl');?>
      <div class="content develop-content">
        <div class="tit">
          <h3><?php echo $yfz['project']['title'];?></h3>
          <p><?php echo $yfz['project']['subtitle'];?></p>
        </div>
        <div class="desc"><?php echo $yfz['project']['content'];?></div>
        <div class="list">
          <ul>
          	<?php $yfz_rslist_id["num"] = 0;$yfz['rslist']=is_array($yfz['rslist']) ? $yfz['rslist'] : array();$yfz_rslist_id["total"] = count($yfz['rslist']);$yfz_rslist_id["index"] = -1;foreach($yfz['rslist'] AS $key=>$value){ $yfz_rslist_id["num"]++;$yfz_rslist_id["index"]++; ?>
            <li><a href="<?php echo $value['url'];?>"><i class="icon-develop icon-<?php echo $value['sort'];?>"></i><p><?php echo $value['title'];?></p></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="product-section">
      <div class="content product-content">
        <div class="tit">
          <h3>产品中心</h3>
          <p>科研制造  为您健康护航</p>
        </div>
		<?php $list = phpok('cpzxfl');?>
		
        <div class="product-list">
          <ul>
          	<?php $list_tree_id["num"] = 0;$list['tree']=is_array($list['tree']) ? $list['tree'] : array();$list_tree_id["total"] = count($list['tree']);$list_tree_id["index"] = -1;foreach($list['tree'] AS $value){ $list_tree_id["num"]++;$list_tree_id["index"]++; ?>
          	<?php $pictures = current($value['pictures']);?>
          		<li><a href="<?php echo $value['url'];?>"><img src="<?php echo $pictures['gd']['auto'];?>" alt=""><h4><?php echo $value['title'];?></h4><p><?php echo $value['subtitle'];?></p></a></li>
			<?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="airticle-section">
      <div class="content airticle-content">
        <div class="img"><img src="tpl/www/images/airticle-b.png" alt=""></div>
        <div class="airticle-type">

          <ul>
          	<?php $xszx = phpok('xszx');?>
            <li><h3>学术中心</h3><h4><?php echo $xszx['title'];?></h4><p><?php echo $xszx['note'];?></p><a href="<?php echo $xszx['url'];?>" class="btn">学术中心</a></li>
            <?php $xwzx = phpok('xwzx');?>
            <li><h3>新闻中心</h3><h4><?php echo $xwzx['title'];?></h4><p><?php echo $xwzx['note'];?></p><a href="<?php echo $xwzx['url'];?>" class="btn">新闻中心</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="contact-section">
      <div class="content contact-content">
        <div class="contact-box">
          <div class="tit">联系我们</div>
          <?php $contact = phpok('contact');?>
          <div class="desc"><?php echo $contact['content'];?></div>
          <ul class="list">
            <li><a href="/index.php?id=cbd"><i class="icon-contact icon-1"></i><p>商务合作</p></a></li>
            <li><a href="/index.php?id=person"><i class="icon-contact icon-2"></i><p>人才合作</p></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="map content">
      <img src="tpl/www/images/map.png" alt="">
    </div>
    
    <?php $arc = phpok('xszx');?>
    <pre><?php echo print_r($arc);?></pre>
  </section>
<script type="text/javascript">
$(document).ready(function(){
	$(".thumb").mouseover(function(){
		var pid = $(this).attr('data-id');
		var thumb = $(this).attr('data');
		$("#product_"+pid).attr("src",thumb);
		$(".thumb[data-id="+pid+"]").removeClass("hover");
		$(this).addClass('hover');
	});
});
</script>


<?php $this->output("foot","file"); ?>


