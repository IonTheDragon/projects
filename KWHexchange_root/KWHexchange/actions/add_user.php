<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/user.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/database.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/config.php';

$database = new Database($sql_user,$sql_host,$sql_password,$sql_database,'stock_kwh');

if (isset($_POST['name']) && isset($_POST['sname']) && isset($_POST['password'])) {

	$name = $_POST['name'];
	$sname = $_POST['sname'];
	$password = $_POST['password'];

	$user = new User();
	$user->update($name,$sname,$password);
	$_SESSION['info'] = 'Created new account '.$user->save($database).'<br>Enter account id and password in "operate" form to work with your account';

}
else $_SESSION['error'] = 'No data';

header("Location: http://localhost/KWHexchange/index.php");
?>