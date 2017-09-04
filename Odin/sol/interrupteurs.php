<?php
	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'allumer'	:
				exec('/usr/bin/php /var/www/html/script/ledzacharieallumer.php');
				break;
			case 'eteindre' :
				exec('/usr/bin/php /var/www/html/script/ledzacharieeteindre.php');
				break;
		}
	}
?>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="inline-W200px">
			<div class="titre">
				<div class="lefttitre"></div>
				Veilleuse Zacharie
			</div>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="colonne">
					<div class="line">
						<form action="/Odin/sol.php" method="get">
							<input type="submit" value="Allumer"/>
							<input type="hidden" name="action" value="allumer">
							<input type="hidden" name="module" value="interrupteurs">
						</form>
					</div>
					<div class="liner"></div>
					<form action="/Odin/sol.php" method="get">
							<input type="submit" value="Eteindre"/>
							<input type="hidden" name="action" value="eteindre">
							<input type="hidden" name="module" value="interrupteurs">
						</form>
				</div>
				<div class="lefttitre"></div>	
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
	</div>
</div>