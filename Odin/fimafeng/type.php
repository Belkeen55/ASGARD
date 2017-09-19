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
			window.open('popup.php?action=edit&type=type&create=TRUE','Creer type','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
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
			window.open('popup.php?action=edit&type=type&id='+id,'Modifier type','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
	}
-->
</script>

<?php
	$types_BDD = $bdd->query(	'SELECT *
								FROM Typ_Equip');
	$nombre_types = $types_BDD->rowCount();
	
?>
<div class="line">
	<div class="display_center">
		<a href="#null" onclick="javascript:create_infos();" class="black">Ajouter un type</a>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
<?php
	if($nombre_types != 0) { // Si il existe des pièces
		while($infos_type = $types_BDD->fetch()) {
?>
			<div class="cadre_sonde">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					<div class="espace_titre"><?php echo $infos_type['Nom']; ?></div>
					<a href="#null" onclick="javascript:open_infos(<?php echo $infos_type['Id']; ?>);"><img src="/img/edit.png" class="image_action"></img></a>
				</div>			
			</div>
<?php
		}
		$types_BDD->closeCursor();
	}
?>
</div>