<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
<title>Green Gecko</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="stylesite.css" type="text/css" media="screen, projection" />
<link rel="shortcut icon" href="images/favicon.png" type="image/png">
<script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script>
<script type="text/javascript">
  VK.init({apiId: 6247373, onlyWidgets: true});
</script>
<script type="text/javascript" src="https://vk.com/js/api/share.js?95" charset="windows-1251"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110390734-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-110390734-1');
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

   $("#tabs").tabs();

});
</script>

<script type="text/javascript">
  function digitalWatch() {
    var date = new Date();
	var day = ["воскресенье","понедельник","вторник","среда","четверг","пятница","суббота"];
	var month = ["января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря"];
    var year = date.getFullYear();
	var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    if (hours < 10) hours = "0" + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;
    document.getElementById("digital_watch").innerHTML = "Сегодня " + day[date.getDay()] + " " + date.getDate() + " " + month[date.getMonth()] + " " + year + " " + hours + ":" + minutes + ":" + seconds;
    setTimeout("digitalWatch()", 1000);
  } 
</script>

</head>
<body onload="digitalWatch()">

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.10';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="main">
<a name="top"></a>
<div class="bg_header">
<h1 style="height:80px;">Конструкторская организация Green Gecko</h1>
<h2>Библиотека новых технологических решений</h2>

<p id="digital_watch" style="position: relative; color: #b1ff00; margin:0pt 20pt; padding:10pt;">...</p>

</div>

