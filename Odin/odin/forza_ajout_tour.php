<?php
	if(isset($_GET['action'])) {
		$bdd->exec('INSERT INTO FM7_Voitures(Id, Marque, Modèle, Année, Division) 
					VALUES(NULL, \'' . $_GET['marque'] . '\', \'' . $_GET['modele'] . '\', ' . $_GET['annee'] . ', ' . $_GET['division'] . ')');
		$voitures_BDD = $bdd->query('SELECT Id
									FROM FM7_Voitures
									WHERE Marque = \'' . $_GET['marque'] . '\'
									AND Modèle = \'' . $_GET['modele'] . '\'
									AND Année = ' . $_GET['annee']);
		$infos_voitures = $voitures_BDD->fetch();
		$voitures_BDD->closeCursor();
		$bdd->exec('INSERT INTO FM7_Reglages(Id, Voiture, Version) 
					VALUES(NULL, ' . $infos_voitures['Id'] . ', 1)');
	}
	$voitures_BDD = $bdd->query('	SELECT FM7_Voitures.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année
									FROM FM7_Voitures');
	$nombre_voitures = $voitures_BDD->rowCount();
?>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		
		<div class="cadre_forza">
			<div class="titre_sonde">
				Ajouter un tour
			</div>
			<div class="valeur_sonde">
				<form action="odin.php" method="get">
					<div class="line"><select name="reglage">
<?php
	$reglages_BDD = $bdd->query('	SELECT FM7_Reglages.Id, FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, FM7_Reglages.Version
									FROM FM7_Voitures, FM7_Reglages
									WHERE FM7_Voitures.Id = FM7_Reglages.Voiture
									AND FM7_Reglages.Version = (SELECT MAX(FM7_Reglages.Version)
									                            FROM FM7_Reglages
									                            WHERE FM7_Reglages.Voiture = FM7_Voitures.Id)
									ORDER BY FM7_Voitures.Marque, FM7_Voitures.Modèle, FM7_Voitures.Année, FM7_Reglages.Version');
	while ($infos_reglage = $reglages_BDD->fetch()) {
		echo '<option value="' . $infos_reglage['Id'] . '">' . $infos_reglage['Marque'] . ' ' . $infos_reglage['Modèle'] . ' (' . $infos_reglage['Année'] . ') V.' . $infos_reglage['Version'] . '</option>';
	}
	$reglages_BDD->closeCursor();				
?>
					</select></div>
					<div class="line"><select name="circuit">
<?php
	$circuits_BDD = $bdd->query('	SELECT Id, Circuit, Portion, `Condition`
									FROM FM7_Circuits 
									ORDER BY Circuit, Portion, `Condition`');
	while ($infos_circuit = $circuits_BDD->fetch()) {
		echo '<option value="' . $infos_circuit['Id'] . '">' . $infos_circuit['Circuit'] . ' ' . $infos_circuit['Portion'] . ' ' . $infos_circuit['Condition'] . '</option>';
	}
	$circuits_BDD->closeCursor();				
?>
					</select></div>
					<div class="line">Minutes : <input type="text" name="minute" size="25"></div>
					<div class="line">Secondes : <input type="text" name="seconde" size="25"></div>
					<div class="line">Millis : <input type="text" name="millis" size="25"></div>
					<div class="line">Europe : <input type="text" name="europe" size="25"></div>
					<div class="line">Amis : <input type="text" name="amis" size="25"></div>
					<div class="line">
						Boite :
						<input type="radio" name="boite" value="1">Allonger
						<input type="radio" name="boite" value="0">Correcte
						<input type="radio" name="boite" value="-1">Raccourcir
					</div>
					<div class="line">
						Différentiel :
						<input type="radio" name="diff" value="1">Serrer
						<input type="radio" name="diff" value="0">Correct
						<input type="radio" name="diff" value="-1">Déserrer
					</div>
					<div class="line">
						Frein :
						<input type="radio" name="frein" value="1">Manque
						<input type="radio" name="frein" value="0">Correct
						<input type="radio" name="frein" value="-1">Trop
					</div>
					<div class="line">
						Virage :
						<input type="radio" name="virage" value="1">Sous-vire
						<input type="radio" name="virage" value="0">Correct
						<input type="radio" name="virage" value="-1">Sur-vire
					</div>
					<div class="line">
						Puissance :
						<input type="radio" name="puissance" value="1">Manque
						<input type="radio" name="puissance" value="0">Correct
						<input type="radio" name="puissance" value="-1">Trop
					</div>
					<input type="hidden" name="module" value="forza">
					<input type="hidden" name="vue" value="tours">
					<input type="hidden" name="action" value="ajout">
					<input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
					<div class="line"><input type="submit" value="Ajouter"></div>
				</form>
			</div>
		</div>
		
	</div>
</div>