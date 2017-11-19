<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $rs['title'].' - '.$cate_rs['title'].' - '.$page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>
<section>
    <div class="content news-detail">
      <div class="title">
        <h3><?php echo $cate_rs ? $cate_rs['title'] : $page_rs['title'];?></h3>
      </div>
      <div class="article-detail">
        <div class="art-tit">
          <h3><?php echo $rs['title'];?></h3>
          <h4><?php echo $rs['note'];?></h4>
          <p class="date"><?php echo date('Y年m月d日',$rs['dateline']);?></p>
        </div>
        <div class="art-content">
          <?php echo $rs['content'];?>
          
        </div>


      </div>



    </div>
  </section>

<?php $this->output("foot","file"); ?>


