<?php
include('Header.php');
?>

<ul class="navigation">
<li id="current">
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
		<h3>Новости сайта</h3>
		<img src="images/GGLogo.png" alt="Logo" width="100" height="100" class="BoxImages" />
		<h4>Учреждена корпорация Green Gecko (неформально)</h4>
		<p>Организация ставит перед собой цель способствовать 
		технологическому прогрессу для формирования	демократического и светского общества. Основная идея 
		компании - решение социальных проблем путём	внедрения новых технологий, призванных улучшить качество 
		жизни, искоренить безграмотность и содействовать формированию сознательного и ответственного гражданина.</p>
		<br>
		<div class="divider"></div>
		<img src="images/Comm.png" alt="Logo" width="150" height="100" class="BoxImages2" />
		<h4>На сайт добавлены проекты коммуникации с контроллером</h4>
		<p>Размещены для бесплатного пользования решения по управлению станком посредством контроллера SIMATIC 
		с панели оператора, а также инструкция по настройке GSM модема для считывания данных с порта RS-232 контроллера FX3G,
		LD-программа контроллера для передачи значений регистров, программный код на Basic для регулярного обзвона контроллеров 
		и считывания данных с COM-порта компьютера при помощи библиотеки <a href="http://www.comm32.com/">comm32.ocx</a> и PHP код 
		сервера с регулярно обновляемой страницей.</p>
	</div>

		<br style="clear:both;">
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Вконтакте</a></li>
				<li><a href="#tabs-2">Facebook</a></li>
			</ul>
			<div id="tabs-1">
		 		<script type="text/javascript">document.write(VK.Share.button(false,{type: "round", text: "Рекомендовать сайт в ВК"}));</script>
				<br style="clear:both;">
				<div id="vk_comments"></div>
				<script type="text/javascript">VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*", pageUrl:"https://stonejungle.org/greengecko/"});</script>
		 	</div>
         	<div id="tabs-2">
				<iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fstonejungle.org%2Fgreengecko%2F&layout=button_count&size=small&mobile_iframe=true&width=104&height=20&appId" width="104" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
				<br style="clear:both;">
				<div class="fb-comments" data-href="https://stonejungle.org/greengecko/" data-width="450" data-numposts="5"></div>
			</div>
		</div>
		
		<br style="clear:both;">
</div>	
<?php	
include('Footer.php');
?>

