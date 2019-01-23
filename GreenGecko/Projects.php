	<div class="LogNote" style="top: 15px; padding-bottom: 20px;">
		<p style="margin-top: 0;">Вам доступны следующие проекты:</p>
   	<?php
		if (isset($_SESSION['logged'])) {
			if ($_SESSION['logged']="Ivan Voznyuk") {
				echo '<p style="color:#ff0000; margin-bottom:0;">Протокол G0</p>
				<p style="padding-bottom:5px; margin-bottom:5px; padding-top:0; margin-top:5px;">
				<a href="SpecAutorize.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</a>
				</p>';
			}	
		}		
   	?>
   		<h4 style = "margin-left:0;margin-bottom:3px">Башня мира</h4>
   		<img src="images/Tower.PNG" alt="Logo" width="100" height="100" class="ProjectImages" />
   		<p style="margin-bottom: 10%; margin-top: 2px">Самодостаточное мегалитическое сооружение, предназначенное для заселения океанических просторов.</p>
   		<div class="test"></div>
	</div>