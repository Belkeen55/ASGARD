<div class="left1pct"></div>
<?php
	if($page == 'odin') {
?>
		<a href="/Odin/odin.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
		<a href="/Odin/odin.php?module=liste_courses&action=view"><div class="ongletsubmenu<?php if($module == 'liste_courses') {echo 'selected';} ?>"><div class="textesubmenu">L. Courses</div></div></a>
		<a href="/Odin/odin.php?module=tickets"><div class="ongletsubmenu<?php if($module == 'tickets') {echo 'selected';} ?>"><div class="textesubmenu">Tickets</div></div></a>
		<a href="/Odin/odin.php?module=forza&vue=dashboard"><div class="ongletsubmenu<?php if($module == 'forza') {echo 'selected';} ?>"><div class="textesubmenu">Forza</div></div></a>
<?php
	}
?>
<?php
	if($page == 'sol') {
?>
		<a href="/Odin/sol.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
		<a href="/Odin/sol.php?module=toutespieces"><div class="ongletsubmenu<?php if($module == 'pieces') {echo 'selected';} ?>"><div class="textesubmenu">Pieces</div></div></a>
		<a href="/Odin/sol.php?module=meteo"><div class="ongletsubmenu<?php if($module == 'meteo') {echo 'selected';} ?>"><div class="textesubmenu">Meteo</div></div></a>
		<a href="/Odin/sol.php?module=interrupteurs"><div class="ongletsubmenu<?php if($module == 'interrupteurs') {echo 'selected';} ?>"><div class="textesubmenu">Interrupteurs</div></div></a>
<?php
	}
?>
<?php
	if($page == 'fimafeng') {
?>
	<a href="/Odin/fimafeng.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
	<a href="/Odin/fimafeng.php?module=equipement"><div class="ongletsubmenu<?php if($module == 'equipement') {echo 'selected';} ?>"><div class="textesubmenu">Elements</div></div></a>
	<a href="/Odin/fimafeng.php?module=piece"><div class="ongletsubmenu<?php if($module == 'piece') {echo 'selected';} ?>"><div class="textesubmenu">Pieces</div></div></a>
	<a href="/Odin/fimafeng.php?module=type"><div class="ongletsubmenu<?php if($module == 'type') {echo 'selected';} ?>"><div class="textesubmenu">Types</div></div></a>
	<a href="/Odin/fimafeng.php?module=maintenance"><div class="ongletsubmenu<?php if($module == 'maintenance') {echo 'selected';} ?>"><div class="textesubmenu">Etat</div></div></a>
	<a href="/Odin/fimafeng.php?module=utilisateurs"><div class="ongletsubmenu<?php if($module == 'utilisateurs') {echo 'selected';} ?>"><div class="textesubmenu">Utilisateurs</div></div></a>
<?php
	}
?>
<div class="right1pct"></div>