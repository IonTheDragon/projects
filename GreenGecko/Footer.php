<div class="foot">
	<ul class="FootNavigation">
	<li>
		<a href="index.php">Главная</a>
	</li>
	<li>
		<a href="technologies.php">Разработки</a>
	</li>
	<li>
		<a href="lectures.php">Лекции</a>
	</li>
	<li>
		<a href="members.php">Участники</a>
	</li>
	<li>
		<a href="./memesi.php">Мемосы</a>
	</li>
	</ul>
	<div class="fright">Новосибирск©2016 Вознюк Иван | Green Gecko.org</div>
</div>

<script type="text/javascript">

//Обработка положения уведомлений
var notes = document.getElementsByClassName('Notes');	

function moveNotes(){
 	var pageScroll = document.documentElement.scrollTop;
	var pageScrollL = document.documentElement.scrollLeft;
 	var docHeight = $(document).height();
	var docWidth = $(document).width();
 	if (docWidth>1000) {
		document.getElementsByClassName('LogNote')[3].style.display = 'block';
		if ((pageScroll>236.233)&&(pageScroll<=950+docHeight-1910)){
			notes[0].classList.add('scrolled');
			notes[0].style.top = 10 + 'px';	
			notes[0].style.marginLeft = 1145 - pageScrollL + 'px';
		} 
		else {
			notes[0].classList.remove('scrolled');
			notes[0].style.marginLeft = '1%';
			if (pageScroll>=950+docHeight-1910){
				notes[0].style.top = 700 + docHeight - 1910 + 'px';
			}	
			else {
				notes[0].style.top = 0;	
			}		
		}
	}	
	else {
			document.getElementsByClassName('LogNote')[3].style.display = 'none';
			notes[0].classList.remove('scrolled');
			notes[0].style.top = 0;
			notes[0].style.marginLeft = '1%';
	}	
}

document.body.onscroll = function (event) {	
 moveNotes();
}

window.onresize = function (event) {
 moveNotes();		
}		

$('a[href=#top]').click(function(){	
$('html, body').animate({scrollTop:0}, 'slow');
return false;
//Источник: http://mainview.ru/programming/javascript/kak-sdelat-plavnuyu-prokrutku-v-nachalo-stranicy-ili-v-konec-stranicy-pri-pomoshhi-jquery
});

</script>

</div>
</body>
</html>