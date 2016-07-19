<div class="left1pct"></div>
<?php
	if($page == 'sol') {
?>
		<a href="/Odin/sol.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
		<a href="/Odin/sol.php?module=chambre"><div class="ongletsubmenu<?php if($module == 'chambre') {echo 'selected';} ?>"><div class="textesubmenu">Chambre</div></div></a>
		<a href="/Odin/sol.php?module=salon"><div class="ongletsubmenu<?php if($module == 'salon') {echo 'selected';} ?>"><div class="textesubmenu">Salon</div></div></a>
		<a href="/Odin/sol.php?module=cuisine"><div class="ongletsubmenu<?php if($module == 'cuisine') {echo 'selected';} ?>"><div class="textesubmenu">Cuisine</div></div></a>
		<a href="/Odin/sol.php?module=meteo"><div class="ongletsubmenu<?php if($module == 'meteo') {echo 'selected';} ?>"><div class="textesubmenu">Meteo</div></div></a>
<?php
	}
?>
<div class="right1pct"></div>