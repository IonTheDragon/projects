<html>
    <head>
        <meta charset="utf-8">
        <title>База данных пользователей</title>
    </head>
<?php
$id = $_GET['id'];
$host = 'localhost';
$login = 'b92312sl_random';
$password = 'password';
$db = 'b92312sl_random';		
$dbase = mysqli_connect($host,$login,$password,$db);
if ($dbase) {
	$res = mysqli_query($dbase,"SELECT * FROM `user_data` WHERE `id`='$id'");
	if (mysqli_num_rows($res)>0) {
		$row = mysqli_fetch_assoc($res);
		echo 'Имя: '.$row['name'].'<br>';	
		echo 'Фамилия: '.$row['sname'].'<br>';
		echo 'Отчество: '.$row['fname'].'<br>';
		echo 'Email: '.$row['email'].'<br>';
		echo 'Пол: '.$row['gender'].'<br>';
		echo 'Тип документа: '.$row['doctype'].'<br>';
		echo 'Номер документа: '.$row['docnum'].'<br>';
		echo 'Доступы: ';
		if($row['access_A']) echo 'A ';
		if($row['access_B']) echo 'Б ';
		if($row['access_C']) echo 'В ';
		echo '<br>';
		echo 'Время записи: '.$row['time'].'<br>';
		echo 'Ip: '.$row['ip'].'<br>';
		echo 'Браузер: '.$row['browser'].'<br>';
	}
	else echo "No data";
}
else echo "Database connection error";
?>
</html>