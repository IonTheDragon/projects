<!DOCTYPE html>
<?php
session_start();
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="stylesite.css" type="text/css" media="screen, projection" />
		<link rel="shortcut icon" href="images/folder.ico" type="image/png">
		<title>Архив видео и изображений</title>
	</head>
	<body style="background-color: #b2e2f2;"> 
		<h1 style="text-align: left;width: 90%;max-width: 250px;margin: 10pt auto; color:#4f44ff;">Архив видео и изображений</h1><br style="clear:both;">
 		<div class="EnterForm" style="margin: 0 auto;">
 			<p style="margin-left: 20pt; padding-right: 10pt; padding-top: 5pt; float: left;">Логин<br>Пароль
 			</p>
			<form action="GetUserGallery.php" method="post">
				<br><input type="text" name="login"><br>
				<input type="password" name="passw"><br>
				<p style="padding-left: 100px;padding-right: 100px;margin-bottom: 5px;"><input type="image" src="images\imgbutton.gif"></p>
			</form>	
			<a href="gallery.php">Назад</a>	
		</div>	
		<?php
 			if (isset($_SESSION['GERROR'])) {
				echo '<p style="margin:0 auto;color:red;text-align: center;font-size: 150%;">'.$_SESSION['GERROR'];
				unset($_SESSION['GERROR']);	
			}						
 		?>			
	</body>
</html>