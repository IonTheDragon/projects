<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/user.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/database.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/config.php';

if (isset($_SESSION['login'])){
	if ($_POST['account'] == $_SESSION['login']['account_id']){

		$account = $_POST['account'];
		$name = $_POST['name'];
		$sname = $_POST['sname'];
		
		$user = new User();
		$database = new Database($sql_user,$sql_host,$sql_password,$sql_database,'stock_kwh');
		$status = $user->load($database,$account);
		if($status){
			$user->update($name,$sname,'');
			$_SESSION['info'] = 'Updated account '.$user->save($database);						
		}
		else $_SESSION['error'] = 'No data found';
		
	}
	else $_SESSION['error'] = "Access denied";
}
else $_SESSION['error'] = "Access denied";

header("Location: http://localhost/KWHexchange/index.php");	

?>