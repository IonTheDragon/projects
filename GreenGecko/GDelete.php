<?php
session_start();

$id_post = $_POST['Id_post']; 

 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
 if ($db) {
 			mysqli_select_db($db,"gg");
 			mysqli_query($db,"SET NAMES UTF-8");
 			$id_post = mysqli_real_escape_string($db,$id_post);
 			if (mysqli_query($db,"DELETE FROM `gallery` WHERE `id_gallery` LIKE '$id_post'") === TRUE)
 			{
 				if (mysqli_query($db,"OPTIMIZE TABLE `gallery`") === TRUE){
					printf("1");					
				}
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
?>