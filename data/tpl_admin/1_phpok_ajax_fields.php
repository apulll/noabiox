<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $rslist_id["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$rslist_id["total"] = count($rslist);$rslist_id["index"] = -1;foreach($rslist AS $key=>$value){ $rslist_id["num"]++;$rslist_id["index"]++; ?>
<li><input type="button" value="<?php echo $value['title'];?>" onclick="fields_click('ext.<?php echo $value['identifier'];?>')" /></li>
<?php } ?>