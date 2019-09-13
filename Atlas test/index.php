<html>
    <head>
        <meta charset="utf-8">
        <title>База данных пользователей</title>
    </head>
    <body>       
        <form action="" id="send_form">
			<p>Имя</p>
			<input type="text" name="name" required="true">
			<p>Фамилия</p>
			<input type="text" name="sname" required="true">
			<p>Отчество</p>
			<input type="text" name="fname" required="true">		
			<p>Email</p>
			<input type="email" name="email">
			<p>Gender</p>
		    <p><select name="gender" required="true">
				<option disabled>Выберите пол</option>
				<option value="Мужской">Мужской</option>
				<option value="Женский">Женский</option>
				<option value="Другое">Другое</option>
		    </select></p>	
			<p>Тип документа</p>
		    <p id="doctype"><select name="doctype" required="true" onchange="custom_field(value)">
				<option disabled>Выберите тип документа</option>
				<option value="0">Паспорт РБ</option>
				<option value="1">Паспорт РФ</option>
				<option value="2">Водительское удостоверение</option>
				<option value="3">Свидетельство о рождении</option>
				<option value="4">Другое (указать)</option>
		    </select></p>	
			<span id="custom_doctype"><input type="text" placeholder="Введите свой тип документа" name="custom_doctype" style="width: 200px;"></span>
			<p>Номер документа</p>
			<input type="text" name="docnum" required="true">	
			<p>Права доступа</p>
		    <p>
				<input type="checkbox" name="access[]" value="1">Права к разделу А</option><br>
				<input type="checkbox" name="access[]" value="2">Права к разделу Б</option><br>
				<input type="checkbox" name="access[]" value="3">Права к разделу В</option><br>
		    </p>
			<p><input type="submit" value="Отправить" id="btn"></p>
		</form>
		<div id="answer_url"></div>
    </body>
</html>

        <script src="https://code.jquery.com/jquery-latest.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v0.6.4/dist/jBox.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v0.6.4/dist/jBox.all.min.css" rel="stylesheet">
        <script>
		$( document ).ready(function() {
			$( "#custom_doctype" ).hide();
			jQuery(function ($) {
				$('#btn').on('click', function () {
					$.post(
						'add_user.php', 
						$("#send_form").serialize()
					)
					.done(function(data){
						console.log(data);
						document.getElementById("answer_url").innerHTML = data;
					});
					return false;
				});
			});	
		});	
	    </script>
		<script>
			function custom_field(value) {
				if (value == 4)	$( "#custom_doctype" ).show();				
				else $( "#custom_doctype" ).hide();					
			}			
		</script>