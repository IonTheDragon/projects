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
<li>
	<a href="lectures.php">Лекции</a>
</li>
<li>
	<a href="members.php">Участники</a>
</li>
<li id="current">
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
	<div class="Box2">
		<h3>Мемесы и приколы</h3>
		<ul class="thumbnail">
		<li> 
			 <a href="memes1.html" target="meme">			
			 	<img src="images\memes1.jpg" alt="memes1" class="Memes" />
			 </a>		
		</li><br style="clear:both;">
		<li>	
			 <a href="memes2.html" target="meme">			
			 	<img src="images\memes2.jpg" alt="memes2" class="Memes" />	
			 </a>		
		</li><br style="clear:both;">
		<li>
			 <a href="memes3.html" target="meme">
			 	<img src="images\memes3.jpg" alt="memes3" class="Memes" />
			 </a>	
		</li><br style="clear:both;">	
		</ul>
		<iframe src="memes1.html" marginwidth="1px" marginheight="1px" width="380" height="482" frameborder="0" scrolling="no" name="meme"></iframe>
		<br style="clear:both;">
		<div class="ManOfMonth">
			<h3 style="padding: 2pt;margin: 2pt;">Человек месяца - Александр Соколов</h3>
			<object width="560" height="315">
			<param name="movie"
			value="https://www.youtube.com/embed/hJh4LfsNPGk">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/hJh4LfsNPGk" frameborder="0" allowfullscreen></iframe>
			</object>	
		</div>		
	</div>	

</div>	
<?php
include('Footer.php');
?>