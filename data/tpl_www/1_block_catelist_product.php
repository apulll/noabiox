<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><ul>
  <?php $list=phpok('_catelist',array('pid'=>$page_rs['id']));?>
  <?php $tmpid["num"] = 0;$list['tree']=is_array($list['tree']) ? $list['tree'] : array();$tmpid["total"] = count($list['tree']);$tmpid["index"] = -1;foreach($list['tree'] AS $key=>$value1){ $tmpid["num"]++;$tmpid["index"]++; ?>
<!--   <pre><?php echo print_r($cate_rs);?></pre> -->
  <li><div class="m <?php if($cate_rs['parent_id'] == $value1['id']){ ?> current <?php } ?>"><span class="t"><?php echo $value1['title'];?></span><i class="arrow"></i></div>
    <ul style="display:block">
      <?php $tmpid["num"] = 0;$value1['sublist']=is_array($value1['sublist']) ? $value1['sublist'] : array();$tmpid["total"] = count($value1['sublist']);$tmpid["index"] = -1;foreach($value1['sublist'] AS $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
      <li <?php if($cate_rs['id'] == $value['id']){ ?> class="current"<?php } ?>><a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><?php echo phpok_cut($value['title'],'15','…');?></a></li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
</ul>