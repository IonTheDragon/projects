<?php
require_once('api.php');

if (empty($_GET['startDate']) || empty($_GET['endDate']) || empty($_GET['userId'])) echo 'Передайте GET параметры startDate, endDate, userId';

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$userId = $_GET['userId'];
$get_holidays = empty($_GET['get_holidays']) ? 0 : $_GET['get_holidays'];

$api = new api($startDate, $endDate, $userId, $get_holidays);
echo $api->get_schedule();