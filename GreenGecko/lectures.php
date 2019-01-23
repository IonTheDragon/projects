<?php
include('Header.php');
?>
<ul class="navigation">
<li>
	<a href="index.php">Главная</a>
</li>
<li>
	<a href="technologies.php">Разработки</a>
</li>
<li id="current">
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
		<h3>Лекции и рефераты</h3>
		<p style="font-size:120%; margin-left:10pt;">Документы представлены в формате txt или html.</p>
		<?php
		 $db = mysqli_connect('localhost','greengecko','Illihan@ru');
		 mysqli_select_db($db,"gg");
 		 mysqli_query($db,"SET NAMES UTF-8");
 		 $query = "SELECT * FROM `lects`";
 	     $res = mysqli_query($db,$query);
 	     echo '<div class="lec">';
 	     echo '<table border="1" width="auto" height="auto">';
 	     echo '<tbody>';
 	      while ($row = mysqli_fetch_row($res)) {
		   if ($row[1]!=NULL && $row[2]!=NULL) {
		   	echo '<tr>';		
		   	echo '<td width="auto">'.'<a href="lecture.php?id='.$row[0].'">'.$row[1].'</a>'.'</td>';
		   	echo '<td>'.$row[3].'</td>';
		   	echo '</tr>';
		   }		   
    	  }
    	  echo '</tbody>';
    	  echo '</table>';
    	  echo '</div>';
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
		echo '<p style="font-size:120%">Загрузите лекцию</p>';	
		echo '<form action=lectsUpload.php method=post enctype=multipart/form-data accept-charset="UTF-8">
			  <p>Имя лекции</p>
			  <textarea name="lectdockname"></textarea>
			  <p>Загружаемый файл в формате txt или html (кодировка UTF-8)</p>
			  <input type=file name="lectdock"><br><br>
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