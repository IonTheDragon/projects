<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['First'])) {
 $_SESSION['First'] = "0";
 $_SESSION['Last'] = "28";
}
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="stylesite.css" type="text/css" media="screen, projection" />
		<link rel="shortcut icon" href="images/folder.ico" type="image/png">
		<title>Архив видео и изображений</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>		
		<script type="text/javascript" src="./jwplayer/jwplayer.js"></script>
	</head>
	<body style="height: 100%">
	<div id="main">
	<div class="MainCol">
		<div class="ColLeft">
			<h1 style="text-align: right;width: 90%;max-width: 250px;margin-right: 20px; color:#4f44ff;">Архив видео и изображений</h1><br style="clear:both;">	
		</div>	
		<div class="ColRight">
			<div class="DownloadFormGallery">
				<?php
					if (isset($_SESSION['Glogged'])) {
						echo '<a href="Gexit.php">Выход</a>';
						echo '<p style="font-size:120%">Разместите фото/видео</p>';	
						echo '<form action=Gupload.php method=post enctype=multipart/form-data accept-charset="UTF-8">
				        	  <p>Заголовок</p>
			 				  <textarea name="FileHeader" style="width: auto;"></textarea>
							  <p>Превью</p>
			  				  <input type="file" name="uploadfile[]">
							  <p>Загружаемый файл</p>
							  <p><input type="radio" name="fselect" value="rad1">Фото
   							  <input type="radio" name="fselect" value="rad2">Видео</p>
			 				  <input type=file name="uploadfile[]"><br><br>
							  <input type=submit value="Загрузить"></form>';	
					}
					else {
						echo 'Для загрузки файла на сервер требуется доступ
						<br>
						<a href="autorizeGallery.php">Авторизация</a>';	
					}
   				?>
   			</div>
   			    <?php
   			 		if (isset($_SESSION['gerr'])) {
						echo '<p style="margin:0 auto;color:red;text-align: center;font-size: 150%;">'.$_SESSION['gerr'];
						unset($_SESSION['gerr']);	
					}
				?>			
		</div>
		<div class="ColCenter">
		
		<?php
		 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
		 if ($db) {
			 mysqli_select_db($db,"gg");
 			 mysqli_query($db,"SET NAMES UTF-8");
			 $lim = $_SESSION['First'].",28";
 			 $query = "SELECT * FROM `gallery`";
 	    	 $res = mysqli_query($db,$query);			 
			 $_SESSION['maxfield'] = mysqli_num_rows($res);
 			 $query = "SELECT * FROM `gallery` LIMIT $lim";
 	    	 $res = mysqli_query($db,$query);
 	    	  while ($row = mysqli_fetch_row($res)) {
 	    	  echo '<div class="galleryBox">';	
 	    	  echo '<a class="PicRef" href="gallery.php?post='.$row[0].'"><img src="./upload/'.$row[2].'" style="border: 3px solid #1b8383;height: 181px;max-width: 244px;"></a>';
 	    	  echo '<div class="postData">';
 	    	  echo $row[1].'<br>';
 	    	  echo $row[5];
 	    	  echo '</div>';
 	    	  echo '</div>';
			}	
			if(!empty($_GET['post'])) {
				$id_post = $_GET['post']; 
				$query = "SELECT * FROM `gallery` WHERE `id_gallery`='$id_post'";
 				$res = mysqli_query($db,$query);
 				$row = mysqli_fetch_row($res);
 				if	(strpos($row[4],"ideo")==1) {
					echo '<div class="videobox">
					<a href="gallery.php" style="float: right;margin-bottom: 5px;"><img src="./images/return.png" style="width:20px;"></a><br>
					<video src="./upload/'.$row[3].'" height="270" id="container" poster="./upload/'.$row[2].'" width="480"> </video> 	
					</div>';
				}
 				if	(strpos($row[4],"mage")==1) {
					echo '<div class="videobox">
					<a href="gallery.php" style="float: right;margin-bottom: 5px;"><img src="./images/return.png" style="width:20px;"></a><br>
					<a href="./upload/'.$row[3].'"><img src="./upload/'.$row[3].'" style="height:351px;width:auto;"></a> 	
					</div>';					
				}							
			} 
    		mysqli_close($db);
		}
		else {
			echo '<p style="color:#ff0000;">Нет подключения к БД</p>';
		}
		 echo '<br>';		
		//
		 echo '<div class="SelectButtons">';	     
 	     echo  '<form action="Listing.php" method="post" style="float: left;">
				  <input type=hidden name="listing" value="first">
				  <input type="image" src="images\first.png" align="top" width="50" height="22"';
					if ($_SESSION['First']==0) {
					 echo ' disabled';	
					}					
		 echo	  '>
		 	    </form>'; 
		 	   	
 	     
 	     echo  '<form action="Listing.php" method="post" style="float: left;">
				  <input type=hidden name="listing" value="back">
				  <input type="image" src="images\back.png" align="top" width="50" height="22"';
					if ($_SESSION['First']-28<0) {
					 echo ' disabled';	
		     		}				  
		 echo	  '>
		 	    </form>';	 
		         	     
 	     
 	     echo  '<form action="Listing.php" method="post" style="float: left;">
				  <input type=hidden name="listing" value="forward">
				  <input type="image" src="images\forward.png" align="top" width="50" height="22"';
					if ($_SESSION['Last']-$_SESSION['maxfield']>0) {
					 echo ' disabled';	
		     		}				  
		 echo	  '>
		 	    </form>';	 	     
 	     
 	     echo  '<form action="Listing.php" method="post" style="float: left;">
				  <input type=hidden name="listing" value="last">
				  <input type="image" src="images\last.png" align="top" width="50" height="22"';
					if ($_SESSION['Last']-$_SESSION['maxfield']>0) {
					 echo ' disabled';	
		     		}				  
		 echo	  '>&nbsp;&nbsp;Show '.$_SESSION['First'].' - '.$_SESSION['Last'].' posts
		 	    </form>'; 
		 echo '</div>';
		//
		?>
			
		</div>	
	</div>
	<div class="foot" style="width:1800px">
		<div class="fright">Новосибирск©2016 Вознюк Иван | Green Gecko.org</div>
	</div>
		<script type="text/javascript"> jwplayer("container").setup({ flashplayer: "./jwplayer/player.swf" }); </script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".videobox").draggable();
			});		
		</script>	
	</div>	
	</body>
</html>