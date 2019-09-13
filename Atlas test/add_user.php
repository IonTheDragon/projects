<?php
function getClientIP() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}	
	return $ip;
}

$id = 0;
if (isset($_POST["name"]) && isset($_POST["sname"]) && isset($_POST["fname"]) && isset($_POST["email"]) && isset($_POST["gender"]) && isset($_POST["doctype"]) && isset($_POST["docnum"]) &&
	$_POST["name"]!="" && $_POST["sname"]!="" && $_POST["fname"]!="" && $_POST["email"]!="" && $_POST["gender"]!="" && $_POST["doctype"]!="" && $_POST["docnum"]!="") { 
	
	$status = "success";
	
	if (mb_strlen($_POST["name"])>128) $status = "Превышена длина строки в 128 символов";
	if (mb_strlen($_POST["sname"])>128) $status = "Превышена длина строки в 128 символов";
	if (mb_strlen($_POST["fname"])>128) $status = "Превышена длина строки в 128 символов";
	if (mb_strlen($_POST["email"])>128) $status = "Превышена длина строки в 128 символов";

	if ($_POST["doctype"]==0) { //RB passport
		$doctype  = "Паспорт РБ";
		if (!preg_match('/^[0-9]{7}$/', $_POST["docnum"]))
			$status = "Номер паспорта РБ должен иметь 7 цифр";
	}
	if ($_POST["doctype"]==1) { //RF passport
		$doctype  = "Паспорт РФ";
		if (!preg_match('/^[0-9]{6}$/', $_POST["docnum"]))
			$status = "Номер паспорта РФ должен иметь 7 цифр";
	}
	if ($_POST["doctype"]==2) { //Driver license
		$doctype  = "Водительская лицензия";
		if (!preg_match('/^[0-9]{10}$/', $_POST["docnum"]))
			$status = "Водительская лицензия должна иметь 10 цифр";
	}
	if ($_POST["doctype"]==3) { //Birth doc
		$doctype  = "Свидетельство о рождении";
		if (!preg_match('/^[0-9]{6}$/', $_POST["docnum"]))
			$status = "Свидетельство о рождении должно иметь 6 цифр";
	}
	if ($_POST["doctype"]==4) {
		if(isset($_POST["custom_doctype"]) && $_POST["custom_doctype"]!="") {
			$doctype = $_POST["custom_doctype"];
			
			if (mb_strlen($doctype)>128) $status = "Превышена длина строки в 128 символов";
			if (mb_strlen($_POST["docnum"])>128) $status = "Превышена длина строки в 128 символов";		
			
		}
		else $status = "Необходимо ввести название документа";
	}
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$status = 'E-mail адрес '.$_POST["email"].' указан неверно';
	}	
	
	if (strcasecmp($status, "success") == 0) {
		if (isset($_POST["access"])) {
			$access = $_POST["access"];
			$access_A = 0;
			$access_B = 0;
			$access_C = 0;
			foreach($access as $value) {
				if($value==1) $access_A = 1;
				if($value==2) $access_B = 1;
				if($value==3) $access_C = 1;
			}
		}	
		
		$host = 'localhost';
		$login = 'b92312sl_random';
		$password = 'password';
		$db = 'b92312sl_random';		
    	$dbase = mysqli_connect($host,$login,$password,$db);
        if ($dbase) {
			date_default_timezone_set('UTC');
			$time = date("Y-m-d H:i:s");
			$ip = getClientIP();
			$browser = $_SERVER['HTTP_USER_AGENT'];
			
 			mysqli_query($dbase,"SET NAMES UTF-8");
    		$name = mysqli_real_escape_string($dbase,$_POST["name"]);
    		$sname = mysqli_real_escape_string($dbase,$_POST["sname"]);
    		$fname = mysqli_real_escape_string($dbase,$_POST["fname"]);
    		$email = mysqli_real_escape_string($dbase,$_POST["email"]);	
    		$gender = mysqli_real_escape_string($dbase,$_POST["gender"]);	
    		$doctype = mysqli_real_escape_string($dbase,$doctype);	
    		$docnum = mysqli_real_escape_string($dbase,$_POST["docnum"]);
			$access_A = mysqli_real_escape_string($dbase,$access_A);
			$access_B = mysqli_real_escape_string($dbase,$access_B);
			$access_C = mysqli_real_escape_string($dbase,$access_C);
			$time = mysqli_real_escape_string($dbase,$time);
			$ip = mysqli_real_escape_string($dbase,$ip);
			$browser = mysqli_real_escape_string($dbase,$browser);
    		mysqli_query($dbase,"INSERT INTO `user_data` VALUES ('','$name','$sname','$fname','$email','$gender','$doctype','$docnum','$access_A','$access_B','$access_C','$time','$ip','$browser')");
			$res = mysqli_query($dbase,"SELECT * FROM `user_data` ORDER BY `id` DESC LIMIT 1");
			$row = mysqli_fetch_assoc($res);
			$id = $row['id'];
			
			$status = '<a href="show_user.php?id='.$id.'">Показать результат</a>';
		}
		else $status = "Database connection error";
		mysqli_close($dbase);
	}		
	
}
else $status = "Заполните все поля";	

echo $status;

?>