<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $rs['title'].' - '.$page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>

<div class="banner about-banner">
  <div class="nbox" <?php if($page_rs['banner']){ ?> style="background-image:url('<?php echo $page_rs['banner']['gd']['auto'];?>')"<?php } ?>></div>
</div>

<section>
    <div class="content">
      <div class="sec-nav">
        <ul>
          <li class="current"><a href="core-technology.html">核心菌种</a></li>
          <li><a href="core-technology.html">工艺制造技术</a></li>
          <li><a href="core-technology.html">应用技术</a></li>
        </ul>
      </div>
      <div class="section-content tech-section">
        <div class="left">
          <div class="type-list">
            <ul>
              <li class="current"><a href="">双歧杆菌</a></li>
              <li><a href="">嗜酸乳杆菌</a></li>
              <li><a href="">瑞士杆菌</a></li>
              <li><a href="">保加利亚乳杆菌</a></li>
              <li><a href="">嗜热链球菌</a></li>
              <li><a href="">植物乳杆菌</a></li>
              <li><a href="">马乳酒样乳杆菌</a></li>
              <li><a href="">乳酸乳球菌</a></li>
              <li><a href="">鼠李糖乳杆菌</a></li>
            </ul>
          </div>

        </div>
        <div class="section-main">
          <div class="main">
            <h3>双歧杆菌</h3>
            <div class="img"><img src="img/core-img-1.png" alt=""></div>
            <p><span>来源：</span>早在1899年，法国巴斯德研究所的儿科医生Henry Tissier从母乳喂养的健康婴儿的粪便中分离出的一种厌氧的革兰氏阳性杆菌，当时命名为Bacillus bifidus。</p>
            <p><span>成果：</span>《中国微生态学杂志》</p>
            <p><span>功效：</span>葡萄糖酸钙、L-乳酸钙、柠檬酸钙酪蛋白磷酸肽、乳糖、柠檬酸、蔗糖甜橙粉（橙香精、麦芽糊精、变性淀粉、 浓缩橙汁）</p>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php $this->output("foot","file"); ?>