<?php
include('Header.php');
?>
<ul class="navigation">
<li>
	<a href="index.php">Главная</a>
</li>
<li>
	<a href="technologies.php">Разработки</a>
</li>
<li>
	<a href="lectures.php">Лекции</a>
</li>
<li>
	<a href="members.php">Участники</a>
</li>
<li>
	<a href="./memesi.php">Мемосы</a>
</li>
<li id="current">
	<a href="autorize.php">Авторизация</a>
</li>
</ul>
<div class="Content">
 <div class="EnterForm">
 	<p style="margin-left: 20pt; padding-right: 10pt; padding-top: 5pt; float: left;">Логин<br>Пароль
 	</p>
	<form action="GetUser.php" method="post">
	<br><input type="text" name="login"><br>
	<input type="password" name="passw"><br>
	<p style="padding-left: 100px;padding-right: 100px;"><input type="image" src="images\imgbutton.gif"></p>
	</form>		
 </div>	
 <?php
 	if (isset($_SESSION['ERROR'])) {
		echo '<p style="margin:0 auto;color:red;text-align: center;font-size: 150%;">'.$_SESSION['ERROR'];
		unset($_SESSION['ERROR']);	
	}
 ?>	
</div>	
<?php
include('Footer.php');
?>

