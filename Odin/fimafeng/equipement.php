<script type="text/javascript">
	<!--
		function create_infos()
	{
		width = 620;
		height = 300;
		if(window.innerWidth)
		{
			var left = (window.innerWidth-width)/2;
			var top = (window.innerHeight-height)/2;
		}
		else
		{
			var left = (document.body.clientWidth-width)/2;
			var top = (document.body.clientHeight-height)/2;
		}
			window.open('popup.php?action=edit&type=equipement&create=TRUE','Creer equipement','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
	}
		function open_infos(id)
		{
			width = 620;
			height = 300;
			if(window.innerWidth)
			{
				var left = (window.innerWidth-width)/2;
				var top = (window.innerHeight-height)/2;
			}
			else
			{
				var left = (document.body.clientWidth-width)/2;
				var top = (document.body.clientHeight-height)/2;
			}
				window.open('popup.php?action=edit&type=equipement&module='+id,'Modifier equipement','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
		}
	-->
</script>

<?php
	//----------------------------------------------------------------------------------
	//			Recuperation des informations de l'equipement dispo en BDD
	//----------------------------------------------------------------------------------
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
									Pieces.Nom AS Location, Typ_Equip.Id AS Type, Typ_Equip.Nom AS Equipement, Equipements.Clonage
									FROM Equipements, Pieces, Typ_Equip
									WHERE Equipements.Id_Pieces = Pieces.Id
									AND Equipements.Id_Typ_Equip = Typ_Equip.Id');
	$nombre_equipements = $equipements_BDD->rowCount();
?>
<div class="line">
	<div class="display_center">
		<a href="#null" onclick="javascript:create_infos();" class="black">Ajouter un équipement</a>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<?php
	if($nombre_equipements != 0) {
		while($infos_equipement = $equipements_BDD->fetch()) {
			$connec = ping($infos_equipement['Ip']);
	//----------------------------------------------------------------------------------
	//					Script d'ouverture de popup pour edit des equipements
	//----------------------------------------------------------------------------------
			if($connec == 1) {				// Et qu'il est pingable
			//----------------------------------------------------------------------------------
			//				Recuperation des informations live de la machine
			//----------------------------------------------------------------------------------
				$temperature = -1;
				$html = file_get_html('http://' . $infos_equipement['Ip'] . '/script/systeme.php');
				foreach($html->find('input[name=temperature]') as $element) 
				$temperature=$element->value;
				$disque = -1;
				foreach($html->find('input[name=disque]') as $element) 
				$disque=$element->value;
				$cpu = -1;
				foreach($html->find('input[name=cpu]') as $element) 
				$cpu=$element->value;
				$ram = -1;
				foreach($html->find('input[name=ram]') as $element) 
				$ram=$element->value;
				$uptime = -1;
				foreach($html->find('input[name=uptime]') as $element) 
				$uptime=$element->value;
				$update = -1;
				foreach($html->find('input[name=update]') as $element) 
				$update=$element->value;
?>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="performances">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left"><?php echo $infos_equipement['Nom']; ?></div>
				<div class="inline-W45pct-right"><a href="#null" onclick="javascript:open_infos(<?php echo $infos_equipement['Id']; ?>);"><img src="/img/edit.png" height="20"></img></a></div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Type : <?php echo $infos_equipement['Equipement']; ?></div>
						<div class="line">IP : <?php echo $infos_equipement['Ip']; ?></div>
						<div class="line">Uptime : <?php echo $uptime; ?></div>
						<div class="line">Temperature Proc : <?php echo $temperature; ?>°C</div>
						<div class="line">Update : <?php echo $update; ?></div>
						<div class="line">P. Clonage : <?php echo $infos_equipement['Clonage']; ?></div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
	</div>
</div>
<?php
		}
		else {	// Si il n'est pas connecté
?>
<div class="line">
	<div class="display_center">
		<div class="inline-W350px">
			<a href="/Odin/fimafeng.php?module=<?php echo strtolower($infos_equipement['Id']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<div class="inline-45pct-left"><?php echo $infos_equipement['Nom']; ?> <img src="/img/log_KO.png" height=10></img></div>
					<div class="inline-W45pct-right"><a href="#null" onclick="javascript:open_infos(<?php echo $infos_equipement['Id']; ?>);"><img src="/img/edit.png" height="20"></img></a></div>
				</div>
			</a>
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Equipement non connecté</div>
						<div class="line">Type : <?php echo $infos_equipement['Equipement']; ?></div>
						<div class="line">IP : <?php echo $infos_equipement['Ip']; ?></div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
	</div>
</div>
<?php
			}
		}
	}
?>