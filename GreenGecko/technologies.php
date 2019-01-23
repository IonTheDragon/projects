<?php
include('Header.php');
?>
<ul class="navigation">
<li>
	<a href="index.php">Главная</a>
</li>
<li id="current">
	<a href="technologies.php">Разработки</a>
</li>
<li>
	<a href="lectures.php">Лекции</a>
</li>
<li>
	<a href="members.php">Участники</a>
</li>
<li>
	<a href="./memesi.php">Мемосы</a>
</li>
<li>
	<?php
	if (isset($_SESSION['logged'])) {
	echo('<a href="exit.php">Выход</a>');	
	}
	else {
	echo('<a href="autorize.php">Авторизация</a>');	
	}
	
	?>
</li>
</ul>
<!--Содержимое пункта меню-->
<div class="Content">
 <div class="Notes">
	<div class="LogNote">
   	<?php
		if (isset($_SESSION['logged'])) {
		echo 'Вы вошли как '.$_SESSION['logged'];	
		}
		else {
		echo 'Вы не авторизованы.'.'<br>'.'Неавторизованные пользователи не могут загружать на сервер документы 
		и инициировать специальные протоколы.';	
		}
   	?>
	</div>
	<?php
		include('Projects.php');
	?>	
	<div class="LogNote" style="top: 30px;">
	 <h4 style="margin-left:0;margin-top:3px">Дополнительные ресурсы</h4>
	 <p>Хостинг видео и изображений</p>
	 <a href="gallery.php">Перейти</a>
	</div>
	<div class="LogNote" style="top: 30px; border-style: none; background-color: transparent; padding: 0;margin-top: 30px;">
	 <a href="#top" title="Прокрутить наверх">&nbsp&nbsp&nbsp&nbsp&nbsp</a>
	</div>	
 </div>
	<div class="Box">
		<h3>Чертежи и пояснительные записки с расчётами</h3>
		<p style="color:#ff0000; font-size:120%; margin-left:10pt;">Внимание! После конструирования изделия по представленным документам 
		необходимо провести испытания</p>
		<?php
		 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
		 mysqli_select_db($db,"gg");
 		 mysqli_query($db,"SET NAMES UTF-8");
 		 $query = "SELECT * FROM `documents`";
 	     $res = mysqli_query($db,$query);
 	      while ($row = mysqli_fetch_row($res)) {
           if ($row[1]!=NULL) {
			echo'<div class="divider"></div>';   
		   	echo '<h4>'.$row[1].'</h4>';
		   }
 	       if ($row[5]!=NULL) {
			$dir = 'docs/'.$row[5];
			$size = getimagesize($dir);
			$initwidth = $size[0];
			$initheight = $size[1];
			$maxwidth = 590;
			if ($initwidth>$maxwidth){
				$width = $maxwidth;
				$height = $initheight*$maxwidth/$initwidth;
			}
			else {
				$width = $initwidth;
				$height = $initheight;
			}	
		   	echo '<div class="prev">
		   	<img src='.'"docs/'.$row[5].'" alt="Preview" class="BoxImages" width='.$width.' height='.$height.'/>
		   	<br style="clear:both;">
		   	</div>';
		   }		   
		   if ($row[2]!=NULL) {
		   	echo '<p style="margin-left:10pt">'.$row[2].'</p>';
		   }
		   if ($row[3]!=NULL && $row[4]!=NULL) {		
		   	echo '<div style="margin-left:10pt">';
		   	echo '<a href='.'"docs/'.$row[3].'">'.$row[3].'</a>';
		   	echo '</div>';
		   	echo '<br>';
		   }		   
    	  }
    	  mysqli_close($db);
    	  if (isset ($_SESSION['err'])) {
		  	echo '<p style="color:#ff0000;">'.$_SESSION['err'].'</p>';
		  	unset($_SESSION['err']);
		  }
		?>
		
	</div>
	
		<div class="DownloadForm">
		<?php
		if (isset($_SESSION['logged'])) {
		echo '<p style="font-size:120%">Создайте свою статью</p>';	
		echo '<form action=upload.php method=post enctype=multipart/form-data accept-charset="UTF-8">
			  <p>Заголовок</p>
			  <textarea name="ArtHead"></textarea>
			  <p>Превью</p>
			  <input type="file" name="uploadfile[]">
			  <p>Краткое описание работы</p>
			  <div class="descr"><textarea name="ArtDescr"></textarea></div>
			  <p>Загружаемый файл; если требуется отправить несколько файлов для одной статьи - отправьте новую форму со следующим файлом, но без заголовка и краткого описания.</p>
			  <input type=file name="uploadfile[]"><br><br>
			  <input type=submit value="Разместить статью"></form>';	
		}
		else {
		echo 'Для загрузки файла на сервер требуется доступ';	
		}
   		?>
   		</div>	

</div>		
<?php
include('Footer.php');
?>