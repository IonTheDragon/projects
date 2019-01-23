<?php
 session_start();
 $login = $_POST['login'];
 $passw = $_POST['passw'];
 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
 if ($db) {
 	mysqli_select_db($db,"gg");
 	mysqli_query($db,"SET NAMES cp1251");
 	$login = mysqli_real_escape_string($db,$login);
 	$passw = mysqli_real_escape_string($db,$passw);
 	$query = "SELECT * FROM `users` WHERE `Login`='$login' AND `Password`='$passw' ";
 	$res = mysqli_query($db,$query);	
 	if (mysqli_num_rows($res)>0) {
 		$row = mysqli_fetch_row($res);
 		$name = $row[3]; 
		$_SESSION['logged'] = $name;
		header("Location: index.php");
		mysqli_close($db);
		exit();	
	 }
	else {
		$_SESSION['ERROR'] = 'Access denied';
		header("Location: autorize.php");
		mysqli_close($db);
		exit();
	 }  
 }
 else {
	$_SESSION['ERROR'] = "Cannot open database";
	header("Location: autorize.php");
	exit();
 }
?>