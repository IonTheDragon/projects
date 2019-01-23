<?php
session_start();
unset($_SESSION['Glogged']);
session_destroy();
header("Location: gallery.php");
exit();
?>