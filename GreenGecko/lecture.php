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
		<div class="LogNote" style="top: 30px; border-style: none; background-color: transparent; padding: 0;margin-top: 30px;">
	 		<a href="#top" title="Прокрутить наверх">&nbsp&nbsp&nbsp&nbsp&nbsp</a>
		</div>	
 </div>
	<div class="back">
	<a href="lectures.php">Назад к списку</a>
	</div>
	<div class="Box">
	<?php
	$id = $_GET['id'];
	$db = mysqli_connect('localhost','greengecko','Illihan@ru');
	mysqli_select_db($db,"gg");
 	mysqli_query($db,"SET NAMES UTF-8");
 	$id = mysqli_real_escape_string($db,$id);
 	$query = "SELECT * FROM `lects` WHERE `lect_id`='$id'";
 	$res = mysqli_query($db,$query);
 	$row = mysqli_fetch_row($res);
 	$title = $row[1];
 	$dir = 'docs/'.$row[2];	
	echo '<h3>'.$title.'</h3>';
	echo '<div style="width:98%; margin-left:10pt;">';
	
	$file = fopen($dir, "r");
	if ($file) {
		flock($file, LOCK_SH);
		while(!feof($file)) {
			echo '<p>'.fgets($file).'</p>';
		}
		flock($file, LOCK_UN);
		fclose($file);
	}
	else {
		echo "Не удалось открыть файл";
	}
	
	echo '</div>';
		
	?>
	</div>
</div>	
<?php
include('Footer.php');
?>