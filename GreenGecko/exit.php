<?php
session_start();
unset($_SESSION['logged']);
unset($_SESSION['ERROR']);
session_destroy();
header("Location: index.php");
exit();
?>