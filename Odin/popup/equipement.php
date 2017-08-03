<?php
	if(isset($_GET['update'])) {
		if(isset($_GET['DHT22'])) {
			$DHT22 = 1;
		}
		else {
			$DHT22 = 0;
		}
		$bdd->exec('UPDATE Equipements
					SET Nom = \'' . str_replace('\'', '\'\'', $_GET['nom']) . '\', 
					Ip = \'' . $_GET['ip'] . '\', 
					Commentaires = \'' . str_replace('\'', '\'\'', $_GET['commentaire']) . '\', 
					Id_Pieces = ' . $_GET['location'] . ', 
					Id_Typ_Equip = ' . $_GET['equip'] . ',
					DHT22 = ' . $DHT22 . '
					WHERE Id = ' . $_GET['module']);
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['creation'])) {
		$clonage = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));
		if(isset($_GET['DHT22'])) {
			$DHT22 = 1;
		}
		else {
			$DHT22 = 0;
		}
		$bdd->exec('INSERT INTO Equipements(Id, Nom, Ip, Commentaires, Id_Pieces, Id_Typ_Equip, Clonage, DHT22) 
					VALUES(NULL, \'' . $_GET['nom'] . '\', \'' . $_GET['ip'] . '\', \'' . $_GET['commentaire'] . '\', ' . $_GET['location'] . ', ' . $_GET['equip'] . ', \'' . $clonage . '\', ' . $DHT22 . ')');
		echo "<script type='text/javascript'>window.close();</script>";	
	}
	if(isset($_GET['delete'])) {
		$bdd->exec('DELETE FROM Equipements WHERE Id = ' . $_GET['module']);
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
	$pieces_BDD = $bdd->query('	SELECT Id, Nom
									FROM Pieces');
	if(!isset($_GET['create'])) {
		$equipements_BDD = $bdd->query('SELECT Id, Nom, Ip, Commentaires, Clonage, Id_Pieces, Id_Typ_Equip, DHT22
										FROM Equipements
										WHERE Id = ' . $_GET['module']);
		$infos_equipement = $equipements_BDD->fetch();
		$equipements_BDD->closeCursor();
		if($infos_equipement['DHT22'] == 1) {
			$DHT22 = "Checked";
		}
		else {
			$DHT22 = "";
		}
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
				$typ_equip_BDD = $bdd->query('	SELECT Id, Nom
												FROM Typ_Equip');
				while ($infos_typ_equip = $typ_equip_BDD->fetch()) {
					if($infos_typ_equip['Id'] == $infos_equipement['Id_Typ_Equip']) {
						echo '<option value="' . $infos_typ_equip['Id'] . '" selected>' . $infos_typ_equip['Nom'] . '</option>';
					}
					else {
						echo '<option value="' . $infos_typ_equip['Id'] . '">' . $infos_typ_equip['Nom'] . '</option>';
					}
				}
				$typ_equip_BDD->closeCursor();				
			?>
		</select>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Periphériques</div>
	<div class="inline-20-Left">
		<input type="checkbox" name="DHT22" value="1"<?php echo $DHT22; ?>> DHT22<br>
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
			<input type="hidden" name="update" value="TRUE">
			<input type="submit" value="Update">
			</form>
		</div>
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
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="equipement">
				<input type="hidden" name="delete" value="TRUE">
				<input type="hidden" name="close" value="TRUE">
				<input type="submit" value="Supprimer">
			</form>
		</div>
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
<?php
	}
	else {
?>
<div class="liner"></div>
<div class="line">
	<form action="popup.php" method="get">
	<div class="inline-20-Left">Nom</div>
	<div class="inline-20-Left">
		<input type="text" name="nom" size="25">
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">IP</div>
	<div class="inline-20-Left"><input type="text" name="ip" size="25"></div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Piece</div>
	<div class="inline-20-Left">
		<select name="location">
			<?php
				while ($infos_piece = $pieces_BDD->fetch()) {
					echo '<option value="' . $infos_piece['Id'] . '">' . $infos_piece['Nom'] . '</option>';
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
				$typ_equip_BDD = $bdd->query('	SELECT Id, Nom
												FROM Typ_Equip');
				while ($infos_typ_equip = $typ_equip_BDD->fetch()) {
					echo '<option value="' . $infos_typ_equip['Id'] . '">' . $infos_typ_equip['Nom'] . '</option>';
				}
				$typ_equip_BDD->closeCursor();				
			?>
		</select>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Periphériques</div>
	<div class="inline-20-Left">
		<input type="checkbox" name="DHT22" value="1"> DHT22<br>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Commentaires</div>
	<div class="inline"><textarea name="commentaire" rows="1" cols="60"></textarea></div>
</div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="equipement">
			<input type="hidden" name="close" value="TRUE">
			<input type="hidden" name="creation" value="TRUE">
			<input type="submit" value="Creer">
			</form>
		</div>
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
<?php
	}
?>