<?php 
use yii\helpers\Url;
?>
<?php if($access=="1") {?>
<form id="edit_task_form" action="/">
	<input type="hidden" name="id" value="<?php echo $params[0];?>">
	<p>Edit task for user <?php echo $params[1];?></p>	
	<p>Change user</p>
	<select name="user">	
		<?php 
		foreach ($persons as $person) {
			?><option value="<?php echo $person->name;?>" <?php if($person->name==$params[1]) echo 'selected';?>><?php echo $person->name;?></option><?php
		}
		?>
	</select>	
	<p style="margin-top:5px;">Title</p>
	<input type="text" name="title" value="<?php echo $params[2];?>">		
	<p style="margin-top:5px;">Status</p>
	<input type="text" name="status" value="<?php echo $params[3];?>">	
	<p style="margin-top:5px;">Description</p>
	<input type="text" name="description" value="<?php echo $params[4];?>"> 
	<button type="submit" name="action" value="1">Save</button>
</form>

<script type="text/javascript">
	$( "#edit_task_form" ).submit(function( event ) {
		  var $form = $(this);
		  $.ajax({
			type: 'POST',
			url: '<?php echo Url::to(['site/edittask']) ?>',
			update: '#newform',
			data: $form.serialize(),
			success:function(data){
                alert(JSON.stringify(data)); 
                document.location.reload(true);
			},
			error:function(data){
                alert(data[0]); 
                document.location.reload(true);
			},			
		  });
		event.preventDefault();
	});
</script>

<?php } else echo'<p>access denied</p>';?>
