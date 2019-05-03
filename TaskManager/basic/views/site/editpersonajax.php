<?php 
use yii\helpers\Url;
?>
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v0.6.4/dist/jBox.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v0.6.4/dist/jBox.all.min.css" rel="stylesheet">
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
				var json_data = jQuery.parseJSON(data);
				new jBox('Notice', {
					offset: {
						y: 50
					},
					content: 'id:'+json_data.id+', name:'+json_data.name+', occupation:'+json_data.occupation+', status:'+json_data.status+', message:'+json_data.message,
					color: 'blue'
				});
                $('#newform').html(''); 
                $(".body-content").css("display","block");  
                $('#ptr'+json_data.id).replaceWith("<tr id=ptr"+json_data.id+"><td>"+json_data.name+"</td><td>"+json_data.occupation+"</td><td><button type=button onclick=edit_person_form("+json_data.id+");>Edit</button></td><td><button type=button onclick=delete_person("+json_data.id+");>Delete</button></td></tr>" );
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
