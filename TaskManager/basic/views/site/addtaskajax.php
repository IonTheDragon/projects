<?php 
use yii\helpers\Url;
?>
<?php if($access=="1") {?>
<form id="add_task_form" action="/">
	<p>Add new task</p>
	<p>User</p>
	<select name="user">	
		<?php 
		foreach ($persons as $person) {
			echo '<option value="'.$person->name.'">'.$person->name.'</option>';
		}
		?>
	</select>		
	<p style="margin-top:5px;">Title</p>
	<input type="text" name="title">		
	<p style="margin-top:5px;">Status</p>
	<input type="text" name="status">	
	<p style="margin-top:5px;">Description</p>
	<input type="text" name="description"> 
	<button type="submit" name="action" value="1">Add</button>
</form>

<script type="text/javascript">
	$( "#add_task_form" ).submit(function( event ) {
		  var $form = $(this);
		  $.ajax({
			type: 'POST',
			url: '<?php echo Url::to(['site/addtask']) ?>',
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
