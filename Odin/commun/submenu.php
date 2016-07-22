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
<?php
	if($page == 'fimafeng') {
?>
		<a href="/Odin/fimafeng.php?module=global"><div class="ongletsubmenu<?php if($module == 'global') {echo 'selected';} ?>"><div class="textesubmenu">Global</div></div></a>
	<?php
		$equipements_BDD = $bdd->query('SELECT	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
											Pieces.Nom AS Location, Type_Equip.Id AS Type, Type_Equip.Image
											FROM Equipements, Pieces, Type_Equip
											WHERE Equipements.Id_Pieces = Pieces.Id
											AND Equipements.Id_Type_Equip = Type_Equip.Id');
		while($infos_equipement = $equipements_BDD->fetch()) {
	?>
		<a href="/Odin/fimafeng.php?module=<?php echo strtolower($infos_equipement['Id']); ?>"><div class="ongletsubmenu<?php if($module == strtolower($infos_equipement['Id'])) {echo 'selected';} ?>"><div class="textesubmenu"><?php echo $infos_equipement['Nom']; ?></div></div></a>
	<?php
		}
		$equipements_BDD->closeCursor();
	?>	
<?php
	}
?>
<div class="right1pct"></div>