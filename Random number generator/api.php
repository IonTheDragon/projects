<?php
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    
    $sections = explode("/", $_SERVER['REQUEST_URI']);

    $host = 'localhost';
    $login = 'b92312sl_random';
    $password = 'password';
    $db = 'b92312sl_random';	
    
    $method = $sections[2];
    
    if (!function_exists('random_int')) {
        function random_int($min, $max) {
            if (!function_exists('mcrypt_create_iv')) {
                trigger_error(
                    'mcrypt must be loaded for random_int to work',
                    E_USER_WARNING
                );
                return null;
            }
           
            if (!is_int($min) || !is_int($max)) {
                trigger_error('$min and $max must be integer values', E_USER_NOTICE);
                $min = (int)$min;
                $max = (int)$max;
            }
           
            if ($min > $max) {
                trigger_error('$max can\'t be lesser than $min', E_USER_WARNING);
                return null;
            }
           
            $range = $counter = $max - $min;
            $bits = 1;
           
            while ($counter >>= 1) {
                ++$bits;
            }
           
            $bytes = (int)max(ceil($bits/8), 1);
            $bitmask = pow(2, $bits) - 1;
    
            if ($bitmask >= PHP_INT_MAX) {
                $bitmask = PHP_INT_MAX;
            }
    
            do {
                $result = hexdec(
                    bin2hex(
                        mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM)
                    )
                ) & $bitmask;
            } while ($result > $range);
    
            return $result + $min;
        }
    }    

	function getFreeId() {
    	global $host;
    	global $login;
    	global $password;
    	global $db;	  	    
        $dbase = mysqli_connect($host,$login,$password,$db);
        if ($dbase) {
 			mysqli_query($dbase,"SET NAMES UTF-8");

				do {
					$requestId = random_int(1, 10000000);
					$requestId = mysqli_real_escape_string($dbase,$requestId);
					$query = "SELECT * FROM `random_numbers` WHERE `requestId`='$requestId'";
					$res = mysqli_query($dbase,$query);
				} while (mysqli_num_rows($res)>0);	

			$answer = $requestId;
		}
		else $answer = 0;
		mysqli_close($dbase);
		return $answer;
	}
	
	function process($method) {
	    
    	global $host;
    	global $login;
    	global $password;
    	global $db;	    
	    
        if (strcasecmp ($method,"Create")==0)
        {
    		$dbase = mysqli_connect($host,$login,$password,$db);
    		if (!$dbase) return json_encode(array('Status' => 0, 'Error' => 'Database connection error'));
    		
    		if (!isset($_POST['min_value']) || !isset($_POST['max_value'])) return json_encode(array('Status' => 0, 'Error' => 'No interval typed'));

    		$min_value = $_POST['min_value'];
    		$max_value = $_POST['max_value'];
    		
    		if ($min_value >= $max_value) return json_encode(array('Status' => 0, 'Error' => 'Wrong interval'));    		
    		
    		try {
    		    $number = random_int($min_value, $max_value);
    		}
    		catch (exception $ex) {
    		   return json_encode(array('Status' => 0, 'Error' => 'You need to type integer'));
    		} 
    		
    		$requestId = getFreeId();
    		if(!$requestId) return json_encode(array('Status' => 0, 'Error' => 'No free id'));
    		
    		mysqli_query($dbase,"SET NAMES UTF-8");
    		$requestId = mysqli_real_escape_string($dbase,$requestId);
    		$number = mysqli_real_escape_string($dbase,$number);
    		mysqli_query($dbase,"INSERT INTO `random_numbers` VALUES ('','$requestId','$number')");
    		mysqli_close($dbase);
    		
    		return json_encode(array('Status' => 1, 'Id' => $requestId));
        }	
    	else if (strcasecmp ($method,'Retrieve')==0) {
    		$requestId = $_POST['id'];
    		//if (!is_int($requestId)) return json_encode(array('Status' => 0, 'Error' => 'You need to type integer'));	
    		$dbase = mysqli_connect($host,$login,$password,$db);
    		if (!$dbase) return json_encode(array('Status' => 0, 'Error' => 'Database connection error'));	
    		$requestId = mysqli_real_escape_string($dbase,$requestId);
    		$query = "SELECT * FROM `random_numbers` WHERE `requestId`='$requestId'";
    		$res = mysqli_query($dbase,$query);	
    		if(mysqli_num_rows($res)>0){
    			$row = mysqli_fetch_assoc($res);
    			$number = $row['number'];	
    			mysqli_close($dbase);
    			return json_encode(array('Status' => 1, 'Number' => $number));
    		}
    		else return json_encode(array('Status' => 0, 'Error' => 'Not Found'));	
    	}
    	else return json_encode(array('Status' => 0, 'Error' => 'Method not Found'));
	}
	echo process($method);

?>