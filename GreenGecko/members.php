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
<li id="current">
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
	<div class="LogNote" style="top: 30px; border-style: none; background-color: #b2e2f2; padding: 0;margin-top: 30px;">
	 <a href="#top" title="Прокрутить наверх">&nbsp&nbsp&nbsp&nbsp&nbsp</a>
	</div>	
 </div>
	<div class="Box">
		<h3>Ведущие работники организации</h3>
		<div class="divider"></div> 
		<h4>Иван Вознюк</h4>
		<p>Инженер-проектировщик коммутационных схем, администратор сайта. Закончил бакалавриат в НГТУ.</p>
		<p>Контакт:<a href="mailto:Ivan@StoneJungle.org">Ivan@StoneJungle.org</a></p>
	</div>

</div>	
<?php
include('Footer.php');
?>