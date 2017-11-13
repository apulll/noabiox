<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $title = $rs['title'].' - '.$page_rs['title'];?>
<?php $title=$title;?><?php $this->assign("title",$title); ?><?php $menutitle=$page_rs['title'];?><?php $this->assign("menutitle",$page_rs['title']); ?><?php $this->output("head","file"); ?>
<div class="banner about-banner">
    <div class="nbox" <?php if($page_rs['banner']){ ?> style="background-image:url('<?php echo $page_rs['banner']['gd']['auto'];?>')"<?php } ?>></div>
  </div>
  <section>
    <div class="content">
      <div class="sec-nav">
        <ul>
          <?php $this->output("block_new_rslist","file"); ?>
        </ul>
      </div>
      <div class="article-content <?php echo $rs['content_class'];?>">
        <?php echo $rs['content'];?>
      </div>
    </div>
  </section>

<?php $this->output("foot","file"); ?>