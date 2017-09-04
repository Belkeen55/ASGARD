<?php
	if(isset($_GET['update'])) {
		if($_GET['password'] <> '') {
			$bdd->exec('UPDATE Utilisateurs
						SET Login = \'' . str_replace('\'', '\'\'', $_GET['login']) . '\', 
						Password = ' . cryptage($_GET['password']) . ', 
						Droits = ' . $_GET['droits'] . ' 
						WHERE Id = ' . $_GET['module']);
		}
		else {
			$bdd->exec('UPDATE Utilisateurs
						SET Login = \'' . str_replace('\'', '\'\'', $_GET['login']) . '\', 
						Droits = ' . $_GET['droits'] . ' 
						WHERE Id = ' . $_GET['module']);
		}
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['creation'])) {
		$bdd->exec('INSERT INTO Utilisateurs(Id, Login, Password, Droits) 
					VALUES(NULL, \'' . $_GET['login'] . '\', ' . cryptage($_GET['password']) . ', ' . $_GET['droits'] . ')');
		echo 'INSERT INTO Utilisateurs(Id, Login, Password, Droits) 
					VALUES(NULL, \'' . $_GET['login'] . '\', \'' . cryptage($_GET['password']) . '\', ' . $_GET['droits'] . ')';
		echo "<script type='text/javascript'>window.close();</script>";	
	}
	if(isset($_GET['delete'])) {
		$bdd->exec('DELETE FROM Utilisateurs WHERE Id = ' . $_GET['module']);
		echo "<script type='text/javascript'>window.close();</script>";	
	}	
	if(isset($_GET['retour'])) {
		echo "<script type='text/javascript'>window.close();</script>";
	}
	$droits_BDD = $bdd->query(		'SELECT Id, Nom
									FROM Typ_Util');
	if(!isset($_GET['create'])) {
		$utilisateurs_BDD = $bdd->query('SELECT Id, Login, Droits
										FROM Utilisateurs
										WHERE Id = ' . $_GET['module']);
		$infos_utilisateur = $utilisateurs_BDD->fetch();
		$utilisateurs_BDD->closeCursor();
?>
<div class="liner"></div>
<div class="line">
	<form action="popup.php" method="get">
	<div class="inline-20-Left">Nom</div>
	<div class="inline-20-Left">
		<input type="text" name="login" size="25" value="<?php echo $infos_utilisateur['Login']; ?>">
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Nouveau password</div>
	<div class="inline-20-Left"><input type="password" name="password" size="25" value=""></div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Droits</div>
	<div class="inline-20-Left">
		<select name="droits">
			<?php
				while ($infos_droit = $droits_BDD->fetch()) {
					if($infos_droit['Id'] == $infos_utilisateurs['Droits']) {
						echo '<option value="' . $infos_droit['Id'] . '" selected>' . $infos_droit['Nom'] . '</option>';
					}
					else {
						echo '<option value="' . $infos_droit['Id'] . '">' . $infos_droit['Nom'] . '</option>';
					}
				}
				$droits_BDD->closeCursor();					
			?>
		</select>
	</div>
</div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="utilisateurs">
			<input type="hidden" name="close" value="TRUE">
			<input type="hidden" name="update" value="TRUE">
			<input type="submit" value="Update">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="utilisateurs">
				<input type="hidden" name="delete" value="TRUE">
				<input type="hidden" name="close" value="TRUE">
				<input type="submit" value="Supprimer">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="utilisateurs">
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
		<input type="text" name="login" size="25">
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Password</div>
	<div class="inline-20-Left"><input type="password" name="password" size="25"></div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Droits</div>
	<div class="inline-20-Left">
		<select name="droits">
			<?php
				while ($infos_droit = $droits_BDD->fetch()) {
					echo '<option value="' . $infos_droit['Id'] . '">' . $infos_droit['Nom'] . '</option>';
				}
				$droits_BDD->closeCursor();					
			?>
		</select>
	</div>
</div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="utilisateurs">
			<input type="hidden" name="close" value="TRUE">
			<input type="hidden" name="creation" value="TRUE">
			<input type="submit" value="Creer">
			</form>
		</div>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="utilisateurs">
				<input type="hidden" name="retour" value="TRUE">
				<input type="submit" value="Annuler">
			</form>
		</div>
	</div>
</div>
<?php
	}
?>