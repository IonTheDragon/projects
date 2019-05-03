<?php 
use yii\helpers\Url;
?>
<script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v0.6.4/dist/jBox.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v0.6.4/dist/jBox.all.min.css" rel="stylesheet">
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
				var json_data = jQuery.parseJSON(data);
				new jBox('Notice', {
					offset: {
						y: 50
					},
					content: 'id:'+json_data.id+', title:'+json_data.title+', user:'+json_data.user+', status:'+json_data.status+', description:'+json_data.description+', message:'+json_data.message,
					color: 'blue'
				});
                $('#newform').html(''); 
                $(".body-content").css("display","block");  
                $('#tr'+json_data.id).replaceWith("<tr id=tr"+json_data.id+"><td>"+json_data.title+"</td><td>"+json_data.user+"</td><td>"+json_data.status+"</td><td>"+json_data.description+"</td><td><button type=button onclick=edit_task_form("+json_data.id+");>Edit</button></td><td><button type=button onclick=delete_task("+json_data.id+");>Delete</button></td></tr>" );              
			},
			error:function(data){
				alert(data[0]);
                $('#newform').html(''); 
                $(".body-content").css("display","block");                 
			},			
		  });
		event.preventDefault();
	});
</script>

<?php } else echo'<p>access denied</p>';?>
