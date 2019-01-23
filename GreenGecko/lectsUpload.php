<?php
session_start();

$lectdockname = $_POST['lectdockname'];

setlocale(LC_ALL, "ru_RU.CP1251", "Russian_Russia.1251");
$date = strftime("%x");

 if (!$_FILES['lectdock']['error']) {
    if (is_uploaded_file($_FILES['lectdock']['tmp_name'])) {
        if (move_uploaded_file($_FILES['lectdock']['tmp_name'], "./docs/".$_FILES['lectdock']['name'])) {
          printf("1");	
	    }
	}      
 }

if (!$_FILES['lectdock']['error']) { 
 $Fname = $_FILES['lectdock']['name'];
 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
 if ($db) {
 			mysqli_select_db($db,"gg");
 			mysqli_query($db,"SET NAMES UTF-8");
 			$lectdockname = mysqli_real_escape_string($db,$lectdockname);
 			$Fname = mysqli_real_escape_string($db,$Fname);
 			$date = mysqli_real_escape_string($db,$date);
 			if (mysqli_query($db,"INSERT INTO `lects` VALUES (NULL,'$lectdockname','$Fname','$date')") === TRUE)
 			{
				printf("1");
			}
			mysqli_close($db);
			header("Location: lectures.php");
			exit();
 		   }
 		   else {
	 		$_SESSION['err'] = "Не удалось подключиться к базе данных";
			header("Location: technologies.php");
	 		exit();
 		   }
}
else {
	  if ($_FILES['lectdock']['error']="UPLOAD_ERR_INI_SIZE"){
	  $_SESSION['err'] = "Ошибка! Превышен допустимый размер файла!"; 
	  header("Location: technologies.php");
	  exit();
	  }
	  else {
			$_SESSION['err'] = "Ошибка! Файл не загружен!";
			header("Location: technologies.php");
	 		exit();
		   }
	  }
?>