<?php 
use yii\helpers\Url;
?>
<?php if($access=="1") {?>
<form id="add_person_form" action="/">
	<p>Add new user</p>
	<p>Name</p>
	<input type="text" name="name">		
	<p style="margin-top:5px;">Occupation</p>
	<input type="text" name="Occupation">		
	<button type="submit" name="action" value="1">Add</button>
</form>

<script type="text/javascript">
	$( "#add_person_form" ).submit(function( event ) {
		  var $form = $(this);
		  $.ajax({
			type: 'POST',
			url: '<?php echo Url::to(['site/addperson']) ?>',
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
