<?php
	if(isset($_GET['update'])) {
		$bdd->exec('UPDATE Typ_Equip
					SET Nom = \'' . str_replace('\'', '\'\'', $_GET['nom']) . '\' 
					WHERE Id = ' . $_GET['id']);
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['creation'])) {
		$bdd->exec('INSERT INTO Typ_Equip(Id, Nom, Image) 
					VALUES(NULL, \'' . $_GET['nom'] . '\', NULL)');
		echo "<script type='text/javascript'>window.close();</script>";	
	}
	if(isset($_GET['delete'])) {
		$bdd->exec('DELETE FROM Typ_Equip WHERE Id = ' . $_GET['id']);
		echo "<script type='text/javascript'>window.close();</script>";	
	}	
	if(isset($_GET['retour'])) {
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(!isset($_GET['create'])) {
		$types_BDD = $bdd->query(	'SELECT *
									FROM Typ_Equip
									WHERE Id = ' . $_GET['id']);
		$infos_type = $types_BDD->fetch();
		$types_BDD->closeCursor();
?>
<div class="liner"></div>
<div class="line">
	<form action="popup.php" method="get">
	<div class="inline-20-Left">Nom</div>
	<div class="inline-20-Left">
		<input type="text" name="nom" size="25" value="<?php echo $infos_type['Nom']; ?>">
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="type">
			<input type="hidden" name="update" value="TRUE">
			<input type="hidden" name="close" value="TRUE">
			<input type="submit" value="Update">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="type">
				<input type="hidden" name="delete" value="TRUE">
				<input type="hidden" name="close" value="TRUE">
				<input type="submit" value="Supprimer">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="type">
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
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="type">
			<input type="hidden" name="creation" value="TRUE">
			<input type="hidden" name="close" value="TRUE">
			<input type="submit" value="Creer">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="type">
				<input type="hidden" name="retour" value="TRUE">
				<input type="submit" value="Annuler">
			</form>
		</div>
	</div>
</div>
<?php
	}
?>