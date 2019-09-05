<?php
 session_start();

 include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/database.php';
 include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/config.php';
 
 $account = $_POST['account'];
 $password = $_POST['password'];

 $db = mysqli_connect($sql_host,$sql_user,$sql_password,$sql_database);
 
 if($db) {
	$account = mysqli_real_escape_string($db,$account);
    $query = "SELECT * FROM `stock_kwh` WHERE `account_id`='$account'";
    $res = mysqli_query($db,$query);
    if (mysqli_num_rows($res)>0) {
        $row = mysqli_fetch_assoc($res);
        $hash = $row['password'];
		if (password_verify ($password, $hash )) {
			$_SESSION['login'] = $row;
			$_SESSION['login']['currency'] = 'KWH';
		}
		else {
			$_SESSION['error'] = "Access denied";
		}		
    }
	else $_SESSION['error'] = "Access denied";
    mysqli_close($db);
 }
 else {
     $_SESSION['error'] = mysqli_connect_error();
 }
 
 header("Location: http://localhost/KWHexchange/index.php");
 
?>