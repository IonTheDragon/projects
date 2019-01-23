<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
<title>Green Gecko</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="stylesite.css" type="text/css" media="screen, projection" />
</head>
<body>
<div id="main">
<div class="SpecialContent">
 <div class="SpecialEnterForm">
	<?php 
	if (!isset($_REQUEST['start'])){
	?>
 	
 	<p style="margin-left: 1pt; padding-right: 10pt; padding-top: 5pt; float: left;">Введите пароль</p>
	<form action="<?=$_SERVER['SCRIPT_NAME']?>">
	<input type="password" name="passw"><br>
	<p style="margin-left: 20pt;"><input type="submit" name="start" value="Подтвердить"></p>
	</form>
	
	<?php
	} else {
 		
	$req = "YouCanStartPray";
	$passw = $_REQUEST['passw'];
	$userip = $_SERVER['REMOTE_ADDR'];
	mb_internal_encoding('UTF-8');
	$theme = "Попытка активации особого протокола";
	$from = "Green Gecko org";
	$theme = mb_encode_mimeheader($theme);
	$from = mb_encode_mimeheader($from);
	$header = "Content-Type: text/plain; charset=UTF-8\r\n";
	$header .= "From: ".$from."GreenGecko.org";
	if ($req == $passw) {
		header("Location: G0Main.php");
		$msg = "Произошёл вход на страницу активации особого протокола с IP адреса ".$userip;
		mail("Ivan@StoneJungle.org",$theme,$msg,$header);
	 	exit();
	}
	else {
		$msg = "Произошла неудачная попытка входа на страницу активации особого протокола с IP адреса ".$userip;
		mail("Ivan@StoneJungle.org",$theme,$msg,$header);
		echo '<p style="color:#000000;>Ваше присутствие засечено. Ожидайте задержания</p>';
	}
  }
  ?>	
 </div>
</div>
</div>
</body>
</html> 