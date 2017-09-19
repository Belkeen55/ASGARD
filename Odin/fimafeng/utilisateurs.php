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
			window.open('popup.php?action=edit&type=utilisateurs&create=TRUE','Creer equipement','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
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
				window.open('popup.php?action=edit&type=utilisateurs&module='+id,'Modifier equipement','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
		}
	-->
</script>

<?php
	//----------------------------------------------------------------------------------
	//			Recuperation des informations de l'equipement dispo en BDD
	//----------------------------------------------------------------------------------
	$utilisateurs_BDD = $bdd->query('SELECT Utilisateurs.Id, Utilisateurs.Login, Typ_Util.Nom AS Droit
									FROM Utilisateurs, Typ_Util
									WHERE Utilisateurs.Droits = Typ_Util.Id');
	$nombre_utilisateurs = $utilisateurs_BDD->rowCount();
?>
<div class="line">
	<div class="display_center">
		<a href="#null" onclick="javascript:create_infos();" class="black">Ajouter un utilisateur</a>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
<?php
	if($nombre_utilisateurs != 0) {
		while($infos_utilisateur = $utilisateurs_BDD->fetch()) {
?>
			<div class="cadre_sonde">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					<div class="espace_titre"><?php echo $infos_utilisateur['Login']; ?></div>
					<a href="#null" onclick="javascript:open_infos(<?php echo $infos_utilisateur['Id']; ?>);"><img src="/img/edit.png" class="image_action"></img></a>
				</div>			
				<div class="cadre_left">
					<div class="liner"></div>
					<div class="lefttitre"></div>
						<div class="colonne">
							<div class="valeur_sonde">Droits : <?php echo $infos_utilisateur['Droit']; ?></div>
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