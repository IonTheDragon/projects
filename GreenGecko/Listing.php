<?php
 session_start();
 $pressedbutton = $_POST['listing'];
 if ($pressedbutton == "first") {
 	$_SESSION['First'] = "0";
 	$_SESSION['Last'] = "28";
 }
 if ($pressedbutton == "last") {
 	$_SESSION['First'] = floor($_SESSION['maxfield']/28)*28;
 	$_SESSION['Last'] = floor($_SESSION['maxfield']/28)*28+28;
 }
 if ($pressedbutton == "forward") {
 	$_SESSION['First'] += 28;
 	$_SESSION['Last'] +=28;
 } 
 if ($pressedbutton == "back") {
 	$_SESSION['First'] -= 28;
 	$_SESSION['Last'] -=28;
 }  
 header("Location: gallery.php");
?>

