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
			window.open('popup.php?action=edit&type=piece&create=TRUE','Creer piece','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
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
			window.open('popup.php?action=edit&type=piece&piece='+id,'Modifier piece','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
	}
-->
</script>

<?php
	$pieces_BDD = $bdd->query(	'SELECT *
								FROM Pieces');
	$nombre_pieces = $pieces_BDD->rowCount();
	
?>
<div class="line">
	<div class="display_center">
		<a href="#null" onclick="javascript:create_infos();" class="black">Ajouter une pièce</a>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
<?php
	if($nombre_pieces != 0) { // Si il existe des pièces
		while($infos_pieces = $pieces_BDD->fetch()) {
?>

	
		<div class="inline-W300px">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left"><?php echo $infos_pieces['Nom']; ?></div>
				<div class="inline-W45pct-right"><a href="#null" onclick="javascript:open_infos(<?php echo $infos_pieces['Id']; ?>);"><img src="/img/edit.png" height="20"></img></a></div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<div class="line">Temperature idéeale : <?php echo $infos_pieces['T_ideal']; ?></div>
						<div class="line">Humidité idéale : <?php echo $infos_pieces['H_ideal']; ?></div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
	

<?php
		}
		$pieces_BDD->closeCursor();
	}
?>
</div>