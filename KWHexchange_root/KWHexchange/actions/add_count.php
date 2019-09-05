<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/user.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/database.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/config.php';


if (isset($_SESSION['login'])){
	if(isset($_POST['count'])) {
		$count = $_POST['count'];
		$user = new User();
		$database = new Database($sql_user,$sql_host,$sql_password,$sql_database,'stock_kwh');
		$status = $user->load($database,$_SESSION['login']['account_id']);
		if($status){
			$fill_status = $user->fill($database,$count);
			if($fill_status) {
				$log = 'Added '.$count.' '.$_SESSION['login']['currency'].' at '.date("Y-m-d H:i:s").PHP_EOL;
				$_SESSION['info'] = $log;
				$file = $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/logs/'.$_SESSION['login']['account_id'].'.log';
				file_put_contents($file, $log, FILE_APPEND);					
			}
			else {
				$_SESSION['error'] = 'Transfer error';
			}
		}
		else $_SESSION['error'] = 'No data found';
	}
	else $_SESSION['error'] = 'No input data'; 
}
else $_SESSION['error'] = "Access denied";

header("Location: http://localhost/KWHexchange/index.php");	

?>