<?php
	if(isset($_GET['nom'])) {
		$bdd->exec('UPDATE Equipements
					SET Nom = \'' . str_replace('\'', '\'\'', $_GET['nom']) . '\', 
					Ip = \'' . $_GET['ip'] . '\', 
					Commentaires = \'' . str_replace('\'', '\'\'', $_GET['commentaire']) . '\', 
					Id_Pieces = ' . $_GET['location'] . ', 
					Id_Type_Equip = ' . $_GET['equip'] . '
					WHERE Id = ' . $_GET['module']);
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['clonage'])) {
		$clonage = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m')+1, date('d'), date('Y')));
		$bdd->exec('UPDATE Equipements
					SET Clonage = \'' . $clonage . '\' 
					WHERE Id = ' . $_GET['module']);
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['retour'])) {
		echo "<script type='text/javascript'>window.close();</script>";
	}
	$equipements_BDD = $bdd->query('SELECT Id, Nom, Ip, Commentaires, Clonage, Id_Pieces, Id_Type_Equip
									FROM Equipements
									WHERE Id = ' . $_GET['module']);
	$infos_equipement = $equipements_BDD->fetch();
	$equipements_BDD->closeCursor();
	$pieces_BDD = $bdd->query('	SELECT Id, Nom
								FROM Pieces');
?>
<div class="liner"></div>
<div class="line">
	<form action="popup.php" method="get">
	<div class="inline-20-Left">Nom</div>
	<div class="inline-20-Left">
		<input type="text" name="nom" size="25" value="<?php echo $infos_equipement['Nom']; ?>">
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">IP</div>
	<div class="inline-20-Left"><input type="text" name="ip" size="25" value="<?php echo $infos_equipement['Ip']; ?>"></div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Piece</div>
	<div class="inline-20-Left">
		<select name="location">
			<?php
				while ($infos_piece = $pieces_BDD->fetch()) {
					if($infos_piece['Id'] == $infos_equipement['Id_Pieces']) {
						echo '<option value="' . $infos_piece['Id'] . '" selected>' . $infos_piece['Nom'] . '</option>';
					}
					else {
						echo '<option value="' . $infos_piece['Id'] . '">' . $infos_piece['Nom'] . '</option>';
					}
				}
				$pieces_BDD->closeCursor();					
			?>
		</select>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Type</div>
	<div class="inline-20-Left">
		<select name="equip">
			<?php
				$type_equip_BDD = $bdd->query('	SELECT Id, Nom
												FROM Type_Equip');
				while ($infos_type_equip = $type_equip_BDD->fetch()) {
					if($infos_type_equip['Id'] == $infos_equipement['Id_Type_Equip']) {
						echo '<option value="' . $infos_type_equip['Id'] . '" selected>' . $infos_type_equip['Nom'] . '</option>';
					}
					else {
						echo '<option value="' . $infos_type_equip['Id'] . '">' . $infos_type_equip['Nom'] . '</option>';
					}
				}
				$type_equip_BDD->closeCursor();				
			?>
		</select>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Commentaires</div>
	<div class="inline"><textarea name="commentaire" rows="1" cols="60"><?php echo $infos_equipement['Commentaires']; ?></textarea></div>
</div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="equipement">
			<input type="hidden" name="close" value="TRUE">
			<input type="submit" value="Update">
			</form>
		</div>
		<?php
			if($infos_equipement['Id_Type_Equip'] == 1) {
		?>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="equipement">
				<input type="hidden" name="clonage" value="TRUE">
				<input type="hidden" name="close" value="TRUE">
				<input type="submit" value="Clonage">
			</form>
		</div>
		<?php
			}
		?>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="equipement">
				<input type="hidden" name="retour" value="TRUE">
				<input type="submit" value="Annuler">
			</form>
		</div>
	</div>
</div>