<?php
    function apiRequest($url, $post=FALSE, $headers=array()) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        if($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        return json_decode($response);
    }
	
	$createId = apiRequest('http://'.$_SERVER['SERVER_NAME'].'/api/Create', array('min_value' => -100, 'max_value' => 100));
	$id = $createId->Id;
	var_dump($id);
	echo '<br>';
	$getNumber = apiRequest('http://'.$_SERVER['SERVER_NAME'].'/api/Retrieve', array('id' => $id));
	//if($getNumber->Status == 0) echo $getNumber->Error;
	//else echo $getNumber->Number;
	var_dump($getNumber);
?>