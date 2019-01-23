<?php
session_start();

$ArtHead = $_POST['FileHeader']; 
$fselect = $_POST['fselect']; 
setlocale(LC_ALL, "ru_RU.CP1251", "Russian_Russia.1251");
$date = strftime("%x");

if ( (strpos($_FILES['uploadfile']['type'][1],"mage")==1&&$fselect=="rad1")||(strpos($_FILES['uploadfile']['type'][1],"ideo")==1&&$fselect=="rad2") ) {

foreach($_FILES['uploadfile']['name'] as $k=>$f) {
 if (!$_FILES['uploadfile']['error'][$k]) {
    if (is_uploaded_file($_FILES['uploadfile']['tmp_name'][$k])) {
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$k], "./upload/".$_FILES['uploadfile']['name'][$k])) {
          printf("1");	
	    }
	}      
 }
}

if (!$_FILES['uploadfile']['error'][1]) { 
 $Preview = $_FILES['uploadfile']['name'][0];
 $Fname = $_FILES['uploadfile']['name'][1];
 $Ftype = $_FILES['uploadfile']['type'][1];
 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
 if ($db) {
 			mysqli_select_db($db,"gg");
 			mysqli_query($db,"SET NAMES UTF-8");
 			$ArtHead = mysqli_real_escape_string($db,$ArtHead);
 			$Preview = mysqli_real_escape_string($db,$Preview);
 			$Fname = mysqli_real_escape_string($db,$Fname);
 			$Ftype = mysqli_real_escape_string($db,$Ftype);
 			if (mysqli_query($db,"INSERT INTO `gallery` VALUES (NULL,'$ArtHead','$Preview','$Fname','$Ftype','$date')") === TRUE)
 			{
				printf("1");
			}
			mysqli_close($db);
			header("Location: gallery.php");
			exit();
 		   }
 		   else {
	 		$_SESSION['gerr'] = "Не удалось подключиться к базе данных";
			header("Location: gallery.php");
	 		exit();
 		   }
}
else {
	  if ($_FILES['uploadfile']['error'][1]="UPLOAD_ERR_INI_SIZE"){
	  $_SESSION['gerr'] = "Ошибка! Превышен допустимый размер файла!"; 
	  header("Location: gallery.php");
	  exit();
	  }
	  else {
			$_SESSION['gerr'] = "Ошибка! Файл не загружен!";
			header("Location: gallery.php");
	 		exit();
		   }
	  }
}
else {
$_SESSION['gerr'] = "Неверный тип файла (".$_FILES['uploadfile']['type'][1].")";
header("Location: gallery.php");
exit();
}	  
?>