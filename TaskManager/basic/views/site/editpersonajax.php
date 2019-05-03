<?php 
use yii\helpers\Url;
?>
<?php if($access=="1") {?>
<form id="edit_person_form" action="/">
	<input type="hidden" name="id" value="<?php echo $params[0];?>">
	<p>Edit user <?php echo $params[1];?></p>	
	<p>Name</p>
	<input type="text" name="title" value="<?php echo $params[1];?>">		
	<p style="margin-top:5px;">Occupation</p>
	<input type="text" name="status" value="<?php echo $params[2];?>">	
	<button type="submit" name="action" value="1">Save</button>
</form>

<script type="text/javascript">
	$( "#edit_person_form" ).submit(function( event ) {
		  var $form = $(this);
		  $.ajax({
			type: 'POST',
			url: '<?php echo Url::to(['site/editperson']) ?>',
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
