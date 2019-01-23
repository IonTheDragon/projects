<?php
session_start();

$ArtHead = $_POST['ArtHead'];
$ArtDescr = $_POST['ArtDescr']; 

foreach($_FILES['uploadfile']['name'] as $k=>$f) {
 if (!$_FILES['uploadfile']['error'][$k]) {
    if (is_uploaded_file($_FILES['uploadfile']['tmp_name'][$k])) {
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$k], "./docs/".$_FILES['uploadfile']['name'][$k])) {
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
 			$ArtDescr = mysqli_real_escape_string($db,$ArtDescr);
 			$Fname = mysqli_real_escape_string($db,$Fname);
 			$Ftype = mysqli_real_escape_string($db,$Ftype);
 			if (mysqli_query($db,"INSERT INTO `documents` VALUES (NULL,'$ArtHead','$ArtDescr','$Fname','$Ftype','$Preview')") === TRUE)
 			{
				printf("1");
			}
			mysqli_close($db);
			header("Location: technologies.php");
			exit();
 		   }
 		   else {
	 		$_SESSION['err'] = "Не удалось подключиться к базе данных";
			header("Location: technologies.php");
	 		exit();
 		   }
}
else {
	  if ($_FILES['uploadfile']['error'][1]="UPLOAD_ERR_INI_SIZE"){
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