<?php
 session_start();
 $_SESSION['number'] = $_POST['num'];
 header("Location: Sowy.php");
?>