<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/user.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/classes/database.php';
include $_SERVER['DOCUMENT_ROOT'].'/KWHexchange/config.php';

if(isset($_SESSION['login'])) {
	
				$db = mysqli_connect($sql_host,$sql_user,$sql_password,$sql_database);
				if($db) {
					$account = $_SESSION['login']['account_id'];
					$account = mysqli_real_escape_string($db,$account);
					$query = "SELECT * FROM `stock_kwh` WHERE `account_id`='$account'";
					$res = mysqli_query($db,$query);
					if (mysqli_num_rows($res)>0) {
						$row = mysqli_fetch_assoc($res);
						$_SESSION['login'] = $row;
						$_SESSION['login']['currency'] = 'KWH';
					}
				}	
	
	?>
	<div style="float:right;margin-right: 35px;">
		<h3><?php echo $_SESSION['login']['name'].' '.$_SESSION['login']['sname']; ?></h3>	
		<p>Account</p>
		<p><?php echo $_SESSION['login']['account_id']; ?></p>	
		<p>Count</p>
		<p><?php echo $_SESSION['login']['count'].' '.$_SESSION['login']['currency']; ?></p>
		<form action="http://localhost/KWHexchange/actions/add_count.php" method="post">
			<h4>Add new KWH</h4>
			<input type="number" name="count" step="0.01" required="true">
			<br>
			<br>
			<input type="submit" value="Enter">			
		</form>
		<form action="http://localhost/KWHexchange/actions/transfer.php" method="post">
			<h4>Transfer KWH</h4>
			<input type="number" name="count" step="0.01" max="<?php echo $_SESSION['login']['count'];?>" required="true">
			<p>to account</p>
			<input type="text" name="account" required="true">
			<br>
			<br>
			<input type="submit" value="Enter">			
		</form>		
	</div>
	<?php
}

?>
<style>
 td {
	padding:5px; 
 }
 body {
	min-width: 1000px;	 
 }
</style>
<table border=1>
	<tr>
		<td style="vertical-align: baseline;">
			<h4>Register</h4>
			<form action="http://localhost/KWHexchange/actions/add_user.php" method="post">
				<p>Name</p>
				<input type="text" name="name" required="true">
				<p>Second name</p>
				<input type="text" name="sname" required="true">
				<p>Password</p>
				<input type="password" name="password" required="true">	
				<br>
				<br>
				<input type="submit" value="Enter">
			</form>
		</td>
		<td style="vertical-align: baseline;">			
			<?php if(isset($_SESSION['login'])) {
				echo '<h4>Edit user</h4>
				<form action="http://localhost/KWHexchange/actions/edit_user.php" method="post">
					<p>New name</p>
					<input type="text" name="name" required="true">
					<p>New second name</p>
					<input type="text" name="sname" required="true">
					<input type="hidden" name="account" value="'.$_SESSION['login']['account_id'].'">
					<br>
					<br>					
					<input type="submit" value="Save">
				</form>
				<form action="http://localhost/KWHexchange/actions/exit.php" method="post">
					<input type="submit" value="Logout">
				</form>				
				';				
			}
			else {
			echo '<h4>Operate</h4>
				<form action="http://localhost/KWHexchange/actions/login.php" method="post">
					<p>Account id</p>
					<input type="text" name="account" required="true">
					<p>Password</p>
					<input type="password" name="password" required="true">	
					<br>
					<br>
					<input type="submit" value="Enter">
				</form>';
			}?>
		</td>	
	</tr>
</table>
<?php

if(isset($_SESSION['error'])) {
	echo '<p style="color:red;">'.$_SESSION['error'].'</p>';	
	unset($_SESSION['error']);
}
if(isset($_SESSION['info'])) {
	echo '<p style="color:green;">'.$_SESSION['info'].'</p>';	
	unset($_SESSION['info']);
}

$database = new Database($sql_user,$sql_host,$sql_password,$sql_database,'stock_kwh');

$users_data = $database->loadUsers();

echo '<h3>KWH stock</h3>';

echo '<table border=1><tr><td>№</td><td>Account id</td><td>Name</td><td>Second name</td><td>Count</td></tr>';
if($users_data) {
	foreach ($users_data as $key => $user_data) {
		echo '<tr><td>'.$key.'</td><td>'.$user_data['account'].'</td><td>'.$user_data['name'].'</td><td>'.$user_data['sname'].'</td><td>'.$user_data['count'].'</td></tr>';
	}
}
echo '</table>';

/*
$user = new User();
$user->update('Ivan','Voznyuk');
echo $user->save($database).'<br>';
$user->info();
$user->update('Ivan','Voznyuk2');
echo $user->save($database).'<br>';
$user->info();
*/

?>