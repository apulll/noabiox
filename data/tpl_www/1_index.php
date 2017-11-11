<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $menutitle="网站首页";?><?php $this->assign("menutitle","网站首页"); ?><?php $this->output("head","file"); ?>
<?php $list = phpok('picplayer');?>
<?php if($list['total']){ ?>
<div class="banner index-banner indexbanner"<?php if($list['project']['height']){ ?> style="height:<?php echo $list['project']['height'];?>px;"<?php } ?>>
	<div class="bd">
	<ul>
		<?php $list_rslist_id["num"] = 0;$list['rslist']=is_array($list['rslist']) ? $list['rslist'] : array();$list_rslist_id["total"] = count($list['rslist']);$list_rslist_id["index"] = -1;foreach($list['rslist'] AS $key=>$value){ $list_rslist_id["num"]++;$list_rslist_id["index"]++; ?>
		<li class="nbox b-1"><a href="<?php echo $value['link'];?>" target="<?php echo $value['target'];?>" title="<?php echo $value['title'];?>"><img src="images/blank.gif" _src="<?php echo $value['banner']['filename'];?>"  alt="<?php echo $value['title'];?>"<?php if($list['project']['height']){ ?> style="height:<?php echo $list['project']['height'];?>px;"<?php } ?> /></a></li>
		<?php } ?>
	</ul>
	</div>
	<div class="hd">
	<ul>
		<?php $tmpid["num"] = 0;$list['rslist']=is_array($list['rslist']) ? $list['rslist'] : array();$tmpid["total"] = count($list['rslist']);$tmpid["index"] = -1;foreach($list['rslist'] AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<li></li>
		<?php } ?>
	</ul>
	</div>
</div>

<!-- <div class="banner index-banner">
    <div id="banner">
      <div class="nbox b-1" style="background-image:url(tpl/www/images/banner.png)"></div>
      <div class="nbox b-1" style="background-image:url(tpl/www/images/banner.png)"></div>
    </div>
  </div> -->


<script type="text/javascript">
$(document).ready(function(){
	$(".indexbanner").slide({'autoPlay':true,'switchLoad':'_src','mainCell':'.bd ul'});
});
</script>
<?php } ?>
<section>
    <div class="about-section">
      <div class="content about-content">
        <h3 class="tit">关于诺佰克</h3>
        <div class="desc">诺佰克(武汉)生物科技有限公司，专注于益生菌资源的开发、生产及应用，致力于为客户及消费者提供安全、优质、创新的益生菌产品，成为最具核心竞争力的益生菌领先企业。</div>
        <div class="list">
          <ul>
            <li><a href="about.html"><i class="icon-about icon-1"></i><p>企业概况</p></a></li>
            <li><a href="mission.html"><i class="icon-about icon-2"></i><p>使命与责任</p></a></li>
            <li><a href="core.html"><i class="icon-about icon-3"></i><p>核心与优势</p></a></li>
            <li><a href="honor.html"><i class="icon-about icon-4"></i><p>资质荣誉</p></a></li>
          </ul>
        </div>
        <div class="about-img"><img src="tpl/www/images/about-img.png" alt=""></div>
      </div>
    </div>
    <div class="develop-section">
      <div class="content develop-content">
        <div class="tit">
          <h3>研发中心</h3>
          <p>科研制造  为您健康护航</p>
        </div>
        <div class="desc">专业技术团队<br>公司现有专家顾问及科研人员20余人，涵盖了微生物学、营养学、生理学、药学、生物化工、食品科学等领域专业人才，80%以上科研人员拥有硕士以上学位。</div>
        <div class="list">
          <ul>
            <li><a href="develop.html"><i class="icon-develop icon-1"></i><p>科研实力</p></a></li>
            <li><a href="core-technology.html"><i class="icon-develop icon-2"></i><p>核心技术</p></a></li>
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

        <div class="product-list">
          <ul>
            <li><a href=""><img src="img/pro-1.png" alt=""><h4>菌粉原料产品</h4><p>筛选优良菌株培养，高水平活菌数。</p></a></li>
            <li><a href=""><img src="img/pro-2.png" alt=""><h4>发酵原料产品</h4><p>复合益生菌发酵，经特有配方、工艺精制而成。</p></a></li>
            <li><a href=""><img src="img/pro-3.png" alt=""><h4>产品应用</h4><p>产品应用广泛，营养升级，美味又健康。</p></a></li>
            <li><a href=""><img src="img/pro-1.png" alt=""><h4>菌粉原料产品</h4><p>筛选优良菌株培养，高水平活菌数。</p></a></li>
            <li><a href=""><img src="img/pro-2.png" alt=""><h4>发酵原料产品</h4><p>复合益生菌发酵，经特有配方、工艺精制而成。</p></a></li>
            <li><a href=""><img src="img/pro-3.png" alt=""><h4>产品应用</h4><p>产品应用广泛，营养升级，美味又健康。</p></a></li>

          </ul>
        </div>
      </div>
    </div>
    <div class="airticle-section">
      <div class="content airticle-content">
        <div class="img"><img src="tpl/www/images/airticle-b.png" alt=""></div>
        <div class="airticle-type">
          <ul>
            <li><h3>学术中心</h3><h4>《Science》报道首项小胶质细胞大规模表征研</h4><p>科学家们首次表征了大脑小胶质细胞（一种免疫防御细胞）的特异表现出来症状，正是一种科学家们研究的方向。</p><a href="academic.html" class="btn">学术中心</a></li>
            <li><h3>新闻中心</h3><h4>《Science》报道首项小胶质细胞大规模表征研</h4><p>科学家们首次表征了大脑小胶质细胞（一种免疫防御细胞）的特异表现出来症状，正是一种科学家们研究的方向。</p><a href="news.html" class="btn">新闻中心</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="contact-section">
      <div class="content contact-content">
        <div class="contact-box">
          <div class="tit">联系我们</div>
          <div class="desc">我们非常愿意为你们<br>提供高品质、有设计的产品和有情谊的服务<br>这是一种天性使然的默契<br>我们是一家人</div>
          <ul class="list">
            <li><a href="contact.html"><i class="icon-contact icon-1"></i><p>商务合作</p></a></li>
            <li><a href="job.html"><i class="icon-contact icon-2"></i><p>人才合作</p></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="map content">
      <img src="tpl/www/images/map.png" alt="">
    </div>
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