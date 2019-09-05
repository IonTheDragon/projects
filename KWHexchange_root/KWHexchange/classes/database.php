<?php

class database 
{
	private $login = '';
	private $password = '';
	private $host = '';
	private $db = '';
	private $table = '';
	
	function __construct($login,$host,$password,$db,$table) {
		$this->login = $login;
		$this->password = $password;
		$this->host = $host;
		$this->db = $db;
		$this->table = $table;
	}	
	
	function getFreeId() {
        $dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
        if ($dbase) {
 			mysqli_query($dbase,"SET NAMES UTF-8");

				do {
					$account_id = random_bytes(8);
					$account_id = mysqli_real_escape_string($dbase,$account_id);
					$query = "SELECT * FROM `$this->table` WHERE `account_id`='$account_id'";
					$res = mysqli_query($dbase,$query);
				} while (mysqli_num_rows($res)>0);	

			$answer = $account_id;
		}
		else $answer = 0;
		mysqli_close($dbase);
		return $answer;
	}
	
	function saveUser($account,$name,$sname,$count,$user_password) {
		if ($account == '') {
			$db_account = bin2hex($this->getFreeId());
			$dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
			if (!$dbase) return 0;
			mysqli_query($dbase,"SET NAMES UTF-8");
			$db_account = mysqli_real_escape_string($dbase,$db_account);
			$name = mysqli_real_escape_string($dbase,$name);
			$sname = mysqli_real_escape_string($dbase,$sname);
			$user_password = mysqli_real_escape_string($dbase,$user_password);
			mysqli_query($dbase,"INSERT INTO `$this->table` VALUES ('','$db_account','$name','$sname','0','$user_password')");
		}
		else {
			$dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
			if (!$dbase) return 0;
			mysqli_query($dbase,"SET NAMES UTF-8");
			$db_account = $account;
			$db_account = mysqli_real_escape_string($dbase,$db_account);
			$name = mysqli_real_escape_string($dbase,$name);
			$sname = mysqli_real_escape_string($dbase,$sname);
			$user_password = mysqli_real_escape_string($dbase,$user_password);
			$count = mysqli_real_escape_string($dbase,$count);			
			$query = "SELECT * FROM `$this->table` WHERE `account_id`='$db_account'";
			$res = mysqli_query($dbase,$query);
			if (mysqli_num_rows($res)>0) 
				mysqli_query($dbase,"UPDATE `$this->table` SET `name`='$name',`sname`='$sname',`count`='$count',`password`='$user_password' WHERE `account_id`='$db_account'");   
			else 
				mysqli_query($dbase,"INSERT INTO `$this->table` VALUES ('','$db_account','$name','$sname','0','$user_password')");
		}
		mysqli_close($dbase);
		return $db_account;
	}
	
	function loadUser($account) {
		$dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
		if (!$dbase) return 0;
		mysqli_query($dbase,"SET NAMES UTF-8");	
		$account = mysqli_real_escape_string($dbase,$account);
		$query = "SELECT * FROM `$this->table` WHERE `account_id`='$account'";
		$res = mysqli_query($dbase,$query);	
		
		if ($this->table == 'stock_kwh') $currency = "KWH";
		
		if (mysqli_num_rows($res)>0) {
			$row = mysqli_fetch_assoc($res);
			$result['name'] = $row['name'];
			$result['sname'] = $row['sname'];
			$result['count'] = $row['count'].' '.$currency;
			$result['account'] = $row['account_id'];	
			$result['password'] = $row['password'];
		}
		else $result = 0;
		mysqli_close($dbase);
		
		return $result;
	}
	
	function loadUsers() {
		$dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
		if (!$dbase) return 0;
		mysqli_query($dbase,"SET NAMES UTF-8");
		$query = "SELECT * FROM `$this->table`";
		$res = mysqli_query($dbase,$query);	
		
		if ($this->table == 'stock_kwh') $currency = "KWH";
		
		if(mysqli_num_rows($res)>0){
			$i=0;
			while ($row = mysqli_fetch_assoc($res)) {	
				$result[$i]['name'] = $row['name'];
				$result[$i]['sname'] = $row['sname'];
				$result[$i]['count'] = $row['count'].' '.$currency;
				$result[$i]['account'] = $row['account_id'];	
				$result[$i]['password'] = $row['password'];	
				$i++;
			}
		}
		else $result = 0;
		mysqli_close($dbase);
		
		return $result;		
	}
	
	function receive($account,$count) {
		$dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
		if (!$dbase) return 0;
		$account = mysqli_real_escape_string($dbase,$account);		
		$query = "SELECT * FROM `$this->table` WHERE `account_id`='$account'";
		$res = mysqli_query($dbase,$query);	
		if(mysqli_num_rows($res)>0){
			$row = mysqli_fetch_assoc($res);
			$old_count = $row['count'];
			$new_count = $old_count + $count;
			$new_count = mysqli_real_escape_string($dbase,$new_count);
			$query = "UPDATE `$this->table` SET `count`='$new_count' WHERE `account_id`='$account'";
			mysqli_query($dbase,$query);	
			mysqli_close($dbase);
			return 1;
		}
		else return 0;
	}
	
	function check($account) {
		$dbase = mysqli_connect($this->host,$this->login,$this->password,$this->db);
		if (!$dbase) return 0;
		$account = mysqli_real_escape_string($dbase,$account);		
		$query = "SELECT * FROM `$this->table` WHERE `account_id`='$account'";
		$res = mysqli_query($dbase,$query);	
		if(mysqli_num_rows($res)>0){
			mysqli_close($dbase);
			return 1;			
		}
		else return 0;
	}
}

?>