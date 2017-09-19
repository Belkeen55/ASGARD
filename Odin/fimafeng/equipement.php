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
	$equipements_BDD = $bdd->query('SELECT Equipements.Id, Equipements.Nom, Equipements.Ip, Typ_Equip.Nom AS Type
									FROM Equipements, Typ_Equip
									WHERE Equipements.Id_Typ_Equip = Typ_Equip.Id');
	$nombre_equipements = $equipements_BDD->rowCount();
?>
<div class="line">
	<div class="display_center">
		<a href="#null" onclick="javascript:create_infos();" class="black">Ajouter un équipement</a>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
<?php
	if($nombre_equipements != 0) {
		while($infos_equipement = $equipements_BDD->fetch()) {
			
?>
			<div class="cadre_sonde">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					<div class="espace_titre"><?php echo $infos_equipement['Nom']; ?></div>
					<a href="#null" onclick="javascript:open_infos(<?php echo $infos_equipement['Id']; ?>);"><img src="/img/edit.png" class="image_action"></img></a>
				</div>			
				<div class="cadre_left">
					<div class="liner"></div>
					<div class="lefttitre"></div>
						<div class="colonne">
							<div class="valeur_sonde">Type : <?php echo $infos_equipement['Type']; ?></div>
							<div class="valeur_sonde">IP : <?php echo $infos_equipement['Ip']; ?></div>
						</div>
					<div class="lefttitre"></div>
					<div class="liner"></div>
				</div>
			</div>
<?php
		}
	}
?>
</div>