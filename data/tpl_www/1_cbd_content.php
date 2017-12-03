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
      <div class="article-content article-business">
        
        
      
     
      <div class="comp-desc">
          <div class="tc"><span>诺佰克将自身的专业知识和技术与客户的需求密切结合在一起，以专业的态度服务每一位合作伙伴。</span></div>
          <h3>专业的项目咨询</h3>
          <p>结合诺佰克对市场的精准视角，根据客户需求，给予客户从市场到研发，从生产到销售，从原料到终端产品的专业建议。</p>
          <h3>个性化的营销服务</h3>
          <p>诺佰克采用个性化的营销服务模式，为客户量身定做针对性的产品方案，以客户为导向设计新品创新。</p>
          <h3>多元化的产品定制</h3>
          <p>诺佰克可为客户提供不同功能的单一菌种，不同菌种的混合配比，功能性菌种与其它功能成分（如益生元）的混合配比使用，以及ODM/OEM代工服务。</p>
      </div>
        <div class="feedback">
          <h3>商务合作</h3>

          <p class="desc">如果您想获得更多灵感，或者想进一步了解诺佰克的产品，欢迎您通过以下渠道和我们联系</p>
          <div class="f-column">
             <?php $list = phpok('lxwm');?>
            <div class="info">
              <p class="comp"><?php echo $list['company'];?></p>
              <p>地址 : <?php echo $list['address'];?></p>
              <p>网址 : <?php echo $config['domain'];?></p>
              <p>邮箱 : <?php echo $list['email'];?></p>
              <p>联系电话 : <?php echo $list['tel'];?></p>
              <div class="img"><img src="<?php echo $list['pic'];?>" alt=""></div>
            </div>
            <div class="feedback-list">
              <?php $form = phpok('zxly');?>
              <form method="post" class="form" id="postform">
              <ul>
                <?php $tmpid["num"] = 0;$form=is_array($form) ? $form : array();$tmpid["total"] = count($form);$tmpid["index"] = -1;foreach($form AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
                <li><?php echo $value['html'];?></li>
                <?php } ?>
                <li><input type="submit" value="发送" class="send-button" /></li>
              </ul>
            </form>
            </div>
          </div>

        </div>
        </div>
    </div>
  </section>
<script type="text/javascript">
$(document).ready(function(){
  $("#postform").submit(function(){
    
    if(!$("#fullname").val()){
      $.dialog.alert('请填写您的姓名');
      return false;
    }
    if(!$("#email").val() && !$("#mobile").val()){
      $.dialog.alert('请留下您的联系方式，邮箱或者手机');
      return false;
    }
    if(!$("#content").val()){
      $.dialog.alert('请填写您的需求');
      return false;
    }
    $(this).ajaxSubmit({
      'url':api_url('post','cbd'),
      'type':'post',
      'dataType':'json',
      'success':function(rs){
        if(rs.status == 'ok'){
          $.dialog.alert('感觉您提交的需求，我们会尽快处理您的需求',function(){
            $.phpok.reload();
          },'succeed');
        }else{
          $.dialog.alert(rs.content);
          return false;
        }
      }
    });
    return false;
  });
});
</script>
<?php $this->output("foot","file"); ?>