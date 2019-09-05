<?php

class user 
{
	private $name = '';
	private $sname = '';
	private $coin = 0;
	private $account = '';
	private $password = '';
	
    function __construct() {
		//print "Init new user<br>";
    }	
	
	function update($new_name, $new_sname, $new_password) {
		$this->name = $new_name;
		$this->sname = $new_sname;
		
		if ($new_password != '') $this->password = password_hash($new_password, PASSWORD_DEFAULT);
	}
	
	function save(database $database) {
		$this->account = $database->saveUser($this->account,$this->name,$this->sname,$this->coin,$this->password);
		return $this->account;
	}
	
	function load(database $database, $account) {
		$userdata = $database->loadUser($account);
		if ($userdata == 0) {
			$status = 0;
		}
		else {
			$this->name = $userdata['name'];
			$this->sname = $userdata['sname'];
			$this->coin = $userdata['count'];
			$this->account = $userdata['account'];
			$this->password = $userdata['password'];
			$status = 1;
		}
		return $status;
	}
	
	function fill(database $database, $count) {
		if ($count == 0) return 0;
		$this->coin += $count;
		$acc = $database->saveUser($this->account,$this->name,$this->sname,$this->coin,$this->password);
		if($acc) {
			$this->account = $acc;
			return 1;
		}
		else return 0;
	}
	
	function transfer(database $database, $account, $count) {
		if ($count == 0) return 0;
		if ($this->account == $account) return 0;
		if ($database->check($account)) {
			$this->coin -= $count;
		}
		else return 0;
		
		$acc = $database->saveUser($this->account,$this->name,$this->sname,$this->coin,$this->password);
		if($acc) {
			$this->account = $acc;
			$status = $database->receive($account,$count);
		}
		else $status = 0;	

		return $status;
	}
	
	function info() {
		return 'Name: '.$this->name.'; Second name: '.$this->sname.'; Count: '.$this->coin.'; Account id: '.$this->account.'<br>';
	}
}

?>