<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><footer class="footer">
    <div class="f-nav">
      <div class="content">
        <div class="menu">
          <div class="col col-1">
            <h3>产品中心</h3>
            <?php $cp = phpok('cpzxfl');?>
            <ul>
              <?php $cp_sublist_id["num"] = 0;$cp['sublist']=is_array($cp['sublist']) ? $cp['sublist'] : array();$cp_sublist_id["total"] = count($cp['sublist']);$cp_sublist_id["index"] = -1;foreach($cp['sublist'] AS $key=>$value){ $cp_sublist_id["num"]++;$cp_sublist_id["index"]++; ?>
              <li><a href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a></li>
              <?php } ?>
            </ul>
          </div>
          <?php $list = phpok('menu');?>

          <?php $list_rslist_id["num"] = 0;$list['rslist']=is_array($list['rslist']) ? $list['rslist'] : array();$list_rslist_id["total"] = count($list['rslist']);$list_rslist_id["index"] = -1;foreach($list['rslist'] AS $key=>$value){ $list_rslist_id["num"]++;$list_rslist_id["index"]++; ?>
          
          <?php if($value['id'] != 1401){ ?>
          <div class="col col-1">
          <h3><?php echo $value['title'];?></h3>
          <ul>
            <?php $value_sonlist_id["num"] = 0;$value['sonlist']=is_array($value['sonlist']) ? $value['sonlist'] : array();$value_sonlist_id["total"] = count($value['sonlist']);$value_sonlist_id["index"] = -1;foreach($value['sonlist'] AS $key=>$valueson){ $value_sonlist_id["num"]++;$value_sonlist_id["index"]++; ?>
            <li><a href="<?php echo $valueson['url'];?>"><?php echo $valueson['title'];?></a></li>
            <?php } ?>
          </ul>
          </div>
          <?php } ?>

          
          <?php } ?>
          <div class="contact-box">
            <h3>诺佰克(武汉)生物科技有限公司</h3>
            <ul>
              <li>地址 : 湖北省武汉市汉南区纱帽街育才路551号</li>
              <li>网址 : www.noabiox.com</li>
              <li>邮箱 : nbk@noabiox.com</li>
              <li>联系电话 : +86 27 5190 9933</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright content">
      <p>京ICP备11017824号-4      京ICP证130164号     Copyright © 2006-2017 诺佰克</p>
      <div class="fr"><img src="tpl/www/images/b-logo.png" alt=""> <a href="" class="back-top"></a></div>
    </div>
    <?php $list = phpok('menu');?>
    <!-- <pre><?php echo print_r($list['rslist']);?></pre> -->

  </footer>
<?php echo phpok_head_css();?>
<?php echo phpok_head_js();?>
<?php echo $app->plugin_html_ap("phpokbody");?></body>
</html>