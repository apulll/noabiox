<?php if(!defined("PHPOK_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head_open","file"); ?>
<script type="text/javascript">
function save()
{
	var obj = art.dialog.opener;
	$("#editopen").ajaxSubmit({
		'url':get_url('upload','editopen_save','id=<?php echo $rs['id'];?>'),
		'type':'post',
		'dataType':'json',
		'success':function(rs){
			if(rs.status == 'ok'){
				$.dialog.alert('附件信息修改成功',function(){
					$.dialog.close();
				},'succeed');
			}
			else
			{
				$.dialog.alert(rs.content);
				return false;
			}
		}
	});
}
</script>
<form method="post" id="editopen" onsubmit="return false;">
<div class="table">
	<div class="title">
		附件名称：
		<span class="note">设置附件的名称，以方便管理</span>
	</div>
	<div class="content"><input type="text" id="title" name="title" class="default" value="<?php echo $rs['title'];?>" /></div>
</div>

<div class="table">
	<div class="title">
		附件说明：
		<span class="note">如需对此附件进行说明，可在这里编写，请不要超过5000字</span>
	</div>
	<div class="content"><?php echo $note;?></div>
</div>
</form>
<?php $this->output("foot_open","file"); ?>