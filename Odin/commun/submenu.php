<div class="left1pct"></div>
<?php
	if($page == 'odin') {
?>
		<a href="/Odin/odin.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
		<a href="/Odin/odin.php?module=smworld"><div class="ongletsubmenu<?php if($module == 'smworld') {echo 'selected';} ?>"><div class="textesubmenu">SM World</div></div></a>
		<a href="/Odin/odin.php?module=tickets"><div class="ongletsubmenu<?php if($module == 'tickets') {echo 'selected';} ?>"><div class="textesubmenu">Tickets</div></div></a>
<?php
	}
?>
<?php
	if($page == 'sol') {
?>
		<a href="/Odin/sol.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
		<a href="/Odin/sol.php?module=chambre"><div class="ongletsubmenu<?php if($module == 'pieces') {echo 'selected';} ?>"><div class="textesubmenu">Pieces</div></div></a>
<?php
	}
?>
<?php
	if($page == 'fimafeng') {
?>
	<a href="/Odin/fimafeng.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
	<a href="/Odin/fimafeng.php?module=equipement"><div class="ongletsubmenu<?php if($module == 'equipements') {echo 'selected';} ?>"><div class="textesubmenu">Equipements</div></div></a>
	<a href="/Odin/fimafeng.php?module=piece"><div class="ongletsubmenu<?php if($module == 'pieces') {echo 'selected';} ?>"><div class="textesubmenu">Pieces</div></div></a>
	<a href="/Odin/fimafeng.php?module=type"><div class="ongletsubmenu<?php if($module == 'type') {echo 'selected';} ?>"><div class="textesubmenu">Types</div></div></a>
<?php
	}
?>
<div class="right1pct"></div>