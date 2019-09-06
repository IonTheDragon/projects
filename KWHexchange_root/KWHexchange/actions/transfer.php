<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/user.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/database.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/config.php';


if (isset($_SESSION['login'])){
	if(isset($_POST['count']) && isset($_POST['account'])) {
		$count = $_POST['count'];
		if($count<=0) {
			$_SESSION['error'] = 'Transfer error';	
		}
		else {
			$account = $_POST['account'];
			$user = new User();
			$database = new Database($sql_user,$sql_host,$sql_password,$sql_database,'stock_kwh');
			$status = $user->load($database,$_SESSION['login']['account_id']);
			if($status){
				$transfer_status = $user->transfer($database,$account,$count);
				if($transfer_status) {
					$log_from = 'Sent '.$count.' '.$_SESSION['login']['currency'].' to '.$account.' at '.date("Y-m-d H:i:s").PHP_EOL;
					$log_to = 'Received '.$count.' '.$_SESSION['login']['currency'].' from '.$_SESSION['login']['account_id'].' at '.date("Y-m-d H:i:s").PHP_EOL;
					$_SESSION['info'] = $log_from;
					$file_from = $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/logs/'.$_SESSION['login']['account_id'].'.log';
					$file_to = $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/logs/'.$account.'.log';
					file_put_contents($file_from, $log_from, FILE_APPEND);
					file_put_contents($file_to, $log_to, FILE_APPEND);					
				}
				else {
					$_SESSION['error'] = 'Transfer error';
				}
			}
			else $_SESSION['error'] = 'No data found';
		}
	}
	else $_SESSION['error'] = 'No input data'; 
}
else $_SESSION['error'] = "Access denied";

header("Location: http://localhost/KWHexchange/index.php");	

?>
