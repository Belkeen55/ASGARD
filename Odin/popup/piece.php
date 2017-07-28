<?php
	if(isset($_GET['update'])) {
		$bdd->exec('UPDATE Pieces
					SET Nom = \'' . str_replace('\'', '\'\'', $_GET['nom']) . '\', 
					T_ideal = ' . $_GET['Temp'] . ', 
					H_ideal = ' . $_GET['Hum'] . ' 
					WHERE Id = ' . $_GET['piece']);
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['creation'])) {
		$bdd->exec('INSERT INTO Pieces(Id, Nom, T_ideal, H_ideal) 
					VALUES(NULL, \'' . $_GET['nom'] . '\',' . $_GET['Temp'] . ', ' . $_GET['Hum'] . ')');
		echo "<script type='text/javascript'>window.close();</script>";	
	}
	if(isset($_GET['delete'])) {
		$bdd->exec('DELETE FROM Pieces WHERE Id = ' . $_GET['piece']);
		echo "<script type='text/javascript'>window.close();</script>";	
	}	
	if(isset($_GET['retour'])) {
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(!isset($_GET['create'])) {
		$pieces_BDD = $bdd->query(	'SELECT *
									FROM Pieces
									WHERE Id = ' . $_GET['piece']);
		$infos_pieces = $pieces_BDD->fetch();
		$pieces_BDD->closeCursor();
?>
<div class="liner"></div>
<div class="line">
	<form action="popup.php" method="get">
	<div class="inline-20-Left">Nom</div>
	<div class="inline-20-Left">
		<input type="text" name="nom" size="25" value="<?php echo $infos_pieces['Nom']; ?>">
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Temperature cible</div>
	<div class="inline-20-Left"><input type="text" name="Temp" size="25" value="<?php echo $infos_pieces['T_ideal']; ?>"></div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Humidité cible</div>
	<div class="inline-20-Left"><input type="text" name="Hum" size="25" value="<?php echo $infos_pieces['H_ideal']; ?>"></div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="piece" value="<?php echo $_GET['piece']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="piece">
			<input type="hidden" name="update" value="TRUE">
			<input type="hidden" name="close" value="TRUE">
			<input type="submit" value="Update">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="piece" value="<?php echo $_GET['piece']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="piece">
				<input type="hidden" name="delete" value="TRUE">
				<input type="hidden" name="close" value="TRUE">
				<input type="submit" value="Supprimer">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="piece" value="<?php echo $_GET['piece']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="piece">
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
	<div class="inline-20-Left">Temperature cible</div>
	<div class="inline-20-Left"><input type="text" name="Temp" size="25"></div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Humidité cible</div>
	<div class="inline-20-Left"><input type="text" name="Hum" size="25"</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="piece">
			<input type="hidden" name="creation" value="TRUE">
			<input type="hidden" name="close" value="TRUE">
			<input type="submit" value="Creer">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="piece">
				<input type="hidden" name="retour" value="TRUE">
				<input type="submit" value="Annuler">
			</form>
		</div>
	</div>
</div>
<?php
	}
?>